WeCamp Challenge 2016
=====================

 - Run `php composer.phar install`
 - Run `php challenge.php`
 
Instructions on using your own datasources
==========================================
 - Remove all files from `/data` 
 - Run `./vendor/bin/doctrine orm:schema-tool:update --force` to initiate sqlite database
 - Add your own sample texts to `/samples` directory
 
Contact
=======
You can find me at <jcdejong@allict.nl> or @jcdejong on twitter

Disclaimer
==========
You can find some example words here:

english-words.txt downloaded from git@github.com:dwyl/english-words.git
english-animals.txt downloaded from https://github.com/hzlzh/Domain-Name-List/blob/master/Animal-words.txt
english-nouns.txt download from http://www.desiquintans.com/nounlist