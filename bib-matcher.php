<?php
	$tex_file = '/home/martin/project/overleaf/2018-lit-review/main.tex';
	$bib_file = '/home/martin/project/overleaf/2018-lit-review/Zotero.bib';
	$output_bib_file = '/home/martin/project/overleaf/2018-lit-review/used_cit.bib';

	$citation_tag = 'cite';

	// open tex file and find all citations
	$tex = file_get_contents($tex_file);
	$used_citations = find_citation_keys($citation_tag, $tex);


	$bib = file_get_contents($bib_file);
	$used_bib_items = get_used_bib_items($bib, $used_citations);

	if(count($used_bib_items) > 0) {
		file_put_contents($output_bib_file, implode("\n\n@", $used_bib_items));
		echo "Wrote used bibligraphy to: " . $output_bib_file . "\n";
	} else {
		echo "No used bibligraphy found. If this is not OK, check input parameters (file names, tag name). If still not OK, please report a bug in Github!\n";
	}

	function get_used_bib_items($bib, $used_citations) {
		$bib_items = preg_split("/\n\s*?\n?@/is", trim($bib));
		$used_bib_items = array();
		$found_keys = array();
		
		foreach ($bib_items as $value) {
			$start_pos = strpos($value, "{") + 1;
			$end_pos = strpos($value, ",");
			// biblio key, e.g., smith_2018
			$key = substr($value, $start_pos, $end_pos - $start_pos);
			// mark it as used if was in .tex file
			if (in_array($key, $used_citations)) {
				array_push($used_bib_items, $value);
				// just for sanity check
				array_push($found_keys, $key);
			}
		}

		// just for error checking
		$mismatch = array_diff($used_citations, $found_keys);

		if (count($mismatch) > 0) {
			throw new Exception("Error. Some biblio items not found (please report bug in github!): " . implode(",", $mismatch), 1);
		}
		echo "\nKept " . count($used_bib_items) . " bibliography items from .bib.\n";
		return $used_bib_items;
	}

	function find_citation_keys($citation_tag, $tex) {
		$used_cit = array();

		// remove citation options
		$tex = preg_replace('/cite\[.*?\]{/u', "cite{", $tex);

		// find all citations
		$cit_tags_count = preg_match_all('/\\\\'.$citation_tag.'([.*?])?{.*?}/u', $tex, $used_cit);

		// remove duplicates
		$used_cit = array_unique($used_cit[0]);

		$cit_keys = array();
		foreach ($used_cit as $idx => $value) {
			// remove citation tag, extract keys
			$key_part = substr($value, 2 + strlen($citation_tag), -1);
			// split keys by comma in case there are several
			$keys = explode(",", $key_part);

			$cit_keys = array_merge($cit_keys, $keys);
		}

		$cit_keys = array_unique($cit_keys);

		echo 'Found ' . $cit_tags_count . ' citation tags and ' . count($cit_keys) . ' unique references' . " from .tex\n";

		return $cit_keys;
	}

?>