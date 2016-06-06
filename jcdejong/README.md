WeCamp Challenge 2016
=====================
Thanks to the WeCamp Challenge I found myself a new pet project ;)

Usage
=====
 - Run `php composer.phar install`
 - Run `php challenge.php` to run with the default text "My brain is a beautiful thing, and I intend to use it at WeCamp"
 - Run `php challenge.php "Your own custom input string"`

If your screen is too small, do this:

 - Run `php challenge.php "Your own custom input string" --vertical`
 
Instructions on using your own datasources and string
=====================================================
 - Remove all files from `/data` 
 - Run `./vendor/bin/doctrine orm:schema-tool:update --force` to initiate sqlite database
 - Add your own sample texts to the `samples/learning` directory
 - Add your own words to `samples/words` directory (use same filename as the sample text)
 
Tips for finding additional words
=================================
 - english animals - downloaded from <https://github.com/hzlzh/Domain-Name-List/blob/master/Animal-words.txt>
 - english nouns - download from <http://www.desiquintans.com/nounlist>
 - english words - downloaded from <https://github.com/dwyl/english-words.git>
 
Contact
=======
You can find me at <jcdejong@allict.nl> or @jcdejong on twitter

Disclaimer
==========
Still under construction, but at this point it is already doing this:
 - determine input language of input string
 - based on the input language create a simple database
 - for each word create a (text)rebus
 - ouput it to the screen
 
Known bugs/issues, still on todo list:
 - if a word cannot be found in the database, result is not very nice
 - all languages are currently inserted in one big pile into the database, rebus (db) should be made language aware
 - to find the rebus, only letters from the left side of the original word are taken, right side is not yet implemented
 - code is far from clean and maintainable, but I tend to use this codebase as input for some courses and maybe a talk
 - implement a image search api and make an actual rebus
 - fix all @todos in code and improve overall :)