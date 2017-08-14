=== This page needs files ===
Contributors: Jacquemin Serge 
Author: Jacquemin Serge 
Author URI: https://profiles.wordpress.org/sergejack
Tags: Stylesheet, CSS, Javascript, JS, Specific, External, File, Page, Post
Requires at least: 4.0.1
Tested up to: 4.2.2
Stable tag: 1.0.7
License: Apache License, Version 2.0
License URI: http://www.apache.org/licenses/LICENSE-2.0

Allow to include urls to javascript and css files inside the HTML header on a page/post specifc basis.

== Screenshots ==

1. When you have some page/post specific files...
2. ...they are easy to include on your page/post.

== Description ==

**Requirements**

PHP 5.3.0 (and above)

**Target Audience**

This plugin is suited for **developpers** and **webdesigners** who create/handle javascript/css files.
This plugin won't help you create javascript/css files.

**Features**

* EN| Easy to use.
* EN| Flexibility for declaring relative/absolute url.
* EN| Possibility to give the link/script an ID you could use in javascript.
* EN| Possibility to control the ordering of links/scripts.
* EN| Completly free.


* FR| Facile d'utilisation.
* FR| Flexibilité pour déclarer une url relative/absolue.
* FR| Possibilité de donner au lien/script un ID que vous pourriez exploiter en javascript.
* FR| Possibilité de contrôler l'ordre des liens/scripts.
* FR| Totalement gratuit.

**Roadmap**

Unless a bug gets reported or I think it's lacking a feature, I don't plan to change it anytime soon.

== Installation ==

1. Search the plugin through the 'Plugins - Add new' menu in WordPress and click on 'Install now'
1. **or** Donwload then upload the zip file through the 'Plugins - Add new' menu then 'Upload Plugin' in Wordpress and click on 'Install now'
1. **or** Donwload then extract the zip file and drop its contents in the wp-content/plugins/ directory of your WordPress installation
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

**Q.** FR| Version française ?

**R.** FR| Plus bas sur cette meme page.

**Q.** En| Why Use It?

**A.** EN| Because some of your javascript/css could only be meaningful for one or a few pages and you don't want to either put it in some website-wide file or either inline it.

**Q.** EN| Shouldn't we keep the number of files as little as possible?

**A.** EN| As a rule of thumb, yes, you should. But as your website and savviness grow large you might figure when it's time to heighten the number of files.

**Q.** EN| What are the system requirements I should be aware of?

**A.** EN| PHP 5.3.0 (and above), Wordpress Theme which fires "wp_footer", HTML5-able browser (for backend), ECMASript enabled (no javascript, no sugar), jQuery (Reminder: Wordpress "comes" with it).

**Q.** EN| "wp_footer"?

**A.** EN| Most Wordpress theme fires it. http://codex.Wordpress.org/Plugin_API/Action_Reference/wp_footer.

**Q.** EN| How do I use it?

**A.** EN| While editing a page/post, go to the "this page needs files" section and add any URL to it.

**Q.** EN| I can't find the section, where is it?

**A.** EN| It's there. Make sure (in "Screen option") you don't have it hidden.

**Q.** EN| Why can't I find the corresponding option in "Screen option"?

**A.** EN| You might have forget to activate the plugin after you have installed it

**Q.** EN| Why do I only see one entry to input a url?

**A.** EN| Because more entries will shows up as you fill in the url

**Q.** EN| How to control in which order my url are rendered?

**A.** EN| You may set a (negative or positive) value to any url's priority. These url will be rendered in their priority ascending order. The lowest the priority is, the higher it will be rendered on the document.

**Q.** EN| What are the boundaries of priority value?

**A.** EN| The boundaries are [-1000, +1000], [TOP - 1000, TOP + 1000], [BOTTOM - 1000, BOTTOM + 1000]

**Q.** EN| What are TOP / BOTTOM?

**A.** EN| Special (case insensitive) keywords you can use in the priority value. TOP will put styles/script on top of the head. BOTTOM will put styles/script at the bottom of the head.

**Q.** EN| Can I combine a value and TOP/BOTTOM?

**A.** EN| Yes, you can set a priority value of "TOP - 1000", "TOP + 55", "BOTTOM - 2", etc. as long as you stay in the boundaries. "B" and "T" are (case insensitive) shorthands for "BOTTOM" and TOP".

**Q.** EN| Where will be rendered my url where no prority have been set?

**A.** EN| When no priority has been set for a url, 0 will be used as priority value.

**Q.** EN| The whole ordering thing doesn't work?!

**A.** EN| Due to how styles/scripts are enqueued using Wordpress, some ordering "magic" had to be done using jQuery. Don't rely of the page source to figure the actual ordering. If there's an issue, check you don't have any javascript error on your page.

**Q.** EN| Why isn't my javascript/css exactly on top/bottom of the head?

**A.** EN| Some other plugin/script must be interfering. This plugin isn't the only player in the game but it will try its best.

**Q.** EN| Can I put javascript/css somewhere else than in the head?

**A.** EN| No, sorry, you can't. There are too many variables to doing that right.

**Q.** EN| Who let the dogs out?!

**A.** EN| Nobody asked that for ages. And the joke is past due.

**Q.** EN| Is this the last English entry of this FAQ?!

**A.** EN| Yes, it is.

**Q.** FR| Pourquoi l'utiliser?

**R.** FR| Parce qu'une partie de votre javascript/css pourrait n'etre pertinent que pour une ou quelques pages et vous ne voulez ni tout inclure dans un fichier portant sur tout le site, ni le mettre en inline.

**Q.** FR| Ne devrions-nous pas garder le nombre de fichiers aussi petit que possible ?

**R.** FR| En regle général, en effet. Mais lorsque votre site et votre expérience grandit, vous pourquoi cerner quand il est temps d'augmenter le nombre de fichiers.

**Q.** FR| Quelles sont les spécifications systeme que je devrais connaître ?

**R.** FR| PHP 5.3.0 (et plus), Theme Wordpress qui déclenche "wp_footer", navigateur supportant HTML5 (pour le backend), ECMASript activé (pas de javascript, pas de chocolat), jQuery (Rappel: Wordpress l'inclut).

**Q.** FR| "wp_footer" ?

**R.** FR| La plupart des themes Wordpress le déclenche. http://codex.Wordpress.org/Plugin_API/Action_Reference/wp_footer.

**Q.** FR| Comment l'utiliser ?

**R.** FR| Lorsque vous éditez une page/post, allez dans la section "this page needs files" et rajouter-y des URL.

**Q.** FR| Je ne trouve pas la section, ou est-elle ?

**R.** FR| Elle est la. Assurez-vous que vous ne l'avez pas cachée (dans "Screen option").

**Q.** FR| Je ne trouve pas l'option correspondante dans "Screen option" ?

**R.** FR| Vous pourriez avoir oublié d'activé le plugin apres l'avoir installé.

**Q.** FR| Pourquoi ne vois-je qu'une seule entrée pour introduire une url ?

**R.** FR| Parce que d'autres entrées apparaitrons tandis que vous introduisez votre url.

**Q.** FR| Comment gérer l'ordre dans lequel sont inclus les urls ?

**R.** FR| Vous pouvez donner une valeur (négative ou positive) aux priorité des url. Les urls seront incluses dans l'ordre croissant de leur priorité. Au plus bas est la priorité, au plus tôt apparaît l'url sur le document.

**Q.** FR| Quelles sont les limites des valeurs des priorités ?

**R.** FR| Les limites sont [-1000, +1000], [TOP - 1000, TOP + 1000], [BOTTOM - 1000, BOTTOM + 1000]

**Q.** FR| Que sont TOP / BOTTOM ?

**R.** FR| Des mots clés (insensibles a la case) que vous pouvez utiliser dans les valeurs des priorité. TOP mettra les styles/script au sommet du head. BOTTOM mettra les styles/script au planché du head.

**Q.** FR| Puis-je combiner valeur et TOP/BOTTOM ?

**R.** FR| Oui, vous pouvez utiliser une valeur de "TOP - 1000", "TOP + 55", "BOTTOM - 2", etc. tant que vous respectez les limites. "B" et "T" sont des raccourcit (insensibles a la case) pour "BOTTOM" et TOP".

**Q.** FR| Ou seront placées mes urls sans priorité définie ?

**R.** FR| Quand il n'y a pas de priorité définie, 0 est considéré comme valeur.

**Q.** FR| L'ordre ne fonctionne pas ?!

**R.** FR| Du a la façon dont les styles/scripts sont agencés par Wordpress, quelques "bricolage" doivent etre fait via jQuery. Ne vous fiez pas a la source d'une page pour vérifier l'ordre. S'il y a un probleme, vérifiez qu'il n'y a pas d'erreur javascript sur votre page.

**Q.** EN| Pourquoi mon javascript/css n'est pas exactement au sommet/au planché du head?

**R.** EN| Certains autres plugins/scripts doivent interférer. Ce plugin n'est pas le seul intervenant dans la partie mais il fera de son mieux.

**Q.** EN| Puis-je mettre du javascript/css ailleurs que dans le head ?

**R.** EN| Non, désolé. Il y a trop de variables pour faire cela correctement.

**Q.** FR| Qui a volé l'orange ?!

**R.** FR| Cette vielle blague n'a plus aucun intéret.

**Q.** FR| Est-ce la derniere ligne en français de cette FAQ ?!

**R.** FR| Oui.

== Changelog ==

1.0.7

- Removed emergency halt (which didn't work on race condition)

1.0.6

- Prevent emergency halt to occur after "user abort"
- Might call php method "ignore_user_abort(true)"

1.0.5

- Feedback and support quick links
- Various improvements

1.0.4

- Back to the initial PHP 5.3+ way of dealing with late static binding
- Revamped how requirements are checked (backward compatibility improved for that matter)

1.0.3

- Alternate approach for late static binding

1.0.2

- Slightly better Regular Expression Pattern for auto detection of files' types

1.0.1

- SPL Types (PECL) not required anymore

1.0.0

- Initial release.
