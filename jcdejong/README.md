WeCamp Challenge 2016
=====================
Thanks to the WeCamp Challenge I found myself a new pet project ;)

Usage
=====
 - Run `php composer.phar install`
 - Run `vendor/bin/doctrine orm:schema-tool:update --force` to initiate sqlite database
 - Run `php challenge.php` to run with the default text "My brain is a beautiful thing, and I intend to use it at WeCamp"
 - Run `php challenge.php "Your own custom input string"`

If your screen is too small, do this:

 - Run `php challenge.php "Your own custom input string" --vertical`
 
Depending on the wordlist used, the output for the default string might look like:

    Here is the rebus to solve:
    ----------------------------
    |  [monkey]   |  [herring]   |  [seal]   |  [wasp]   |  [mule]   |  [starling]   |  [reindeer]   |  [viper]   |  [eland]   |  [chamois]   |  [goose]   |  [oyster]   |  [meerkat]   |  [chimpanzee]   |
    |  monke=m    |  herr=bra    |    i+     |    -w     | m=beautif |   starl=th    |    rei=a      |    -v      |  ela=inte  |   cham=t     |   goo=u    |   oys=i     |  meerka=a    |    chi=weca     |
    |             |     -g       |   -eal    |   -sp     |    -e     |               |     -eer      |   -per     |            |     -is      |            |    -er      |              |     -anzee      |

or

    Here is the rebus to solve:
    ----------------------------
    |  [quality]   |  [rainbow]   |  [consul]   |  [acoustics]   |  [full]   |  [pitching]   |  [handicap]   |  [comparison]   |  [attendant]   |  [uniform]   |  [weasel]   |  [chateau]   |  [worthy]   |  [campanile]   |
    |  qualit=m    |     b+       |   con=i     |   -coustics    |  beauti+  |    pitc=t     |     ha=a      |    -compar      |     at=in      |   unif=t     |   wea=u     |    cha=i     |   wor=a     |      we+       |
    |              |    -bow      |    -ul      |                |    -l     |               |    -icap      |      -son       |     -ant       |     -rm      |     -l      |    -eau      |    -hy      |    -anile      |

As you can see, the word "pictured" is enclosed in brackets, below that word are the instructions to make the actual word.

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
 - ouput it to the console
 
Known bugs/issues, still on todo list:

 - if a word cannot be found in the database, instructions are basically to remove everything and add the word..
 - code is far from clean and maintainable, but I tend to use this codebase as input for some courses and maybe a talk
 - implement a image search api and make an actual rebus
 - fix all @todos in code and improve overall :)
