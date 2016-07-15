var WordLib = require('./wordLib.js');
var wordLibrary = new WordLib();

var inputString = String('My brain is a beautiful thing, and I intend to use it at WeCamp!');

console.log(`Doing stuff with string: "${inputString}" \n`);
var inputStringWithNoPunctuation = inputString.replace(/[!,]/g,'').toLowerCase();
var arrayOfWords = inputStringWithNoPunctuation.split(" ");

var totalProcessTime = 0;
var totalTries = 0;
var outputString = arrayOfWords.map((word) => {
  var start = Date.now();

  var wordPattern = wordLibrary.determinePattern(word);

  var wordNotFound = true;

  var i = 0;
  console.log(`Trying to recreate "${word}" using generateRandomWord()...`);
  while(wordNotFound) {
    var randomWord = wordLibrary.generateRandomWord(wordPattern);
    if (randomWord === word) {
      wordNotFound = false;
    }
    i++;
  }
  var end = Date.now();
  var processTime = (end - start);

  console.log(`The word "${randomWord}" has been randomly generated after ${i} tries, process took ${processTime} ms...\n`);
  totalTries += i;
  totalProcessTime += processTime;
  return randomWord;
});

console.log(`We've randomly created "${outputString.join(' ')}" from "${inputString}"`);
console.log(`This process took ${Math.floor(totalProcessTime/1000)} seconds and ${totalTries} random words guesses.`);
