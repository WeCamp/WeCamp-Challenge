var consonants = ['b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'n', 'p', 'q', 'r', 's', 't', 'v', 'w', 'x', 'y', 'z'];
var vowels = ['a', 'e', 'i', 'o', 'u'];

module.exports = function() {
  return {
    determinePattern: function(word) {
      console.log(`Analyzing pattern of "${word}"...`);

      var characters = word.split('');

      var pattern = characters.map((character) => {
        return this.determineCharacterType(character);
      });
      return pattern;
    },

    determineCharacterType: function(character) {
      if (vowels.indexOf(character) !== -1) {
        return 'v';
      }
      return 'c'
    },

    generateRandomWord(pattern) {
      return pattern.map((character) => {
        if (character === 'v') {
          return this.generateRandomVowel();
        }
        return this.generateRandomConsonant();
      }).join('');
    },

    generateRandomVowel() {
      var vowel = this.randomItemFrom(vowels);
      return vowel;
    },

    generateRandomConsonant() {
      var consonant = this.randomItemFrom(consonants);
      return consonant;
    },

    randomItemFrom(array) {
      return array[Math.floor(Math.random() * array.length)];
    },
  }

}
