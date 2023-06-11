# MediaWiki BlueLL Skin

[MediaWiki](https://www.mediawiki.org) skin focused on a clean and elegant design, initially developed for [Lingua Libre](https://lingualibre.org).


## Download

First, copy the BlueLL source files into your MediaWiki skins directory (see [skinning](https://www.mediawiki.org/wiki/Manual:Skinning) for general information on MediaWiki skins). You can either download the files and extract them from:

    https://github.com/lingua-libre/BlueLL/archive/master.zip

You should extract that into a folder named `BlueLL` in your `skins` directory.

Alternatively, you can use git to clone the repository, which makes it very easy to update the code, using:

    git clone https://github.com/lingua-libre/BlueLL.git

After that, you can issue `git pull` to update the code at anytime.

## Setup

Once the skin is in place add one the following lines to your `LocalSettings.php` file.

	wfLoadSkin( 'BlueLL' );

This will activate BlueLL in your installation. At this point you can select it as a user skin in your user preferences.

To activate BlueLL for all users and anonymous visitors, you need to set the `$wgDefaultSkin` variable and set it to `bluell`.

    $wgDefaultSkin = "bluell";

## Contribute
[Wikimedia Pabricator](https://phabricator.wikimedia.org/tag/lingua_libre/) is our main issues tracker.
- Wikimedians can create "New Task" or open "New Bug Report" [on Phabricator](https://phabricator.wikimedia.org/tag/lingua_libre/).
- Non-wikimedians users, please open [an Github issue here](../../issues).
