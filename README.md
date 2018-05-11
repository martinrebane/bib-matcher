# bib-matcher / Filter your bibliography file
Compares you .tex file and .bib file and generates a new .bib file keeping only the entries that are used in .tex, optionally filters out bibliography fields

## Keep only relevant references

In essence, you can use your full bibliography file to write the LaTex document and when you are ready, apply this script which will parse .tex file to find out which entries were actually used. It will then generate a new .bib file containing only those entries. So you do not have to send your whole bibliography to a journal or edit it manually.

## Remove irrelevant fields
Further, you can optionally remove bibliography fields you do not need or do not want to distribute (only works for fields that are on one line, no nested structures). For example, easily filter out URL, URLDATE or similar fields.

## System requirements
Linux, Windows, Mac.. No operating system requirements, you just need PHP installed to run this script from a command line or terminal. Install it using your operating system's software manager or [download](http://php.net/downloads.php) the installer.

## Configuration

Just edit the fields at the top of bib-matcher.php, specify the location of your .tex and .bib file, the tag you use for citations (default is "cite"), and any fields you would like to remove from bibliography entries (optional).

## Quick start

1. Download bib-matcher.php (or `git clone https://github.com/martinrebane/bib-matcher.git` if you use git)
2. Edit the configuation at the top of the file
3. Open command line or terminal
4. Go to the folder where you placed your bib-matcher.php file
5. Run `php bib-matcher.php`

DONE! Now find your newly generated .bib file and copy it into your LaTex project, removing the old one.

## FAQ
**Will it work with more complex citations?**  
Yes, currently bib-matcher will match citations like those:    

```
\cite{key}  
\cite{key1,key2,keyN}  
\cite[options]{key}  
\cite[options]{key1,key2,keyN}  
```
