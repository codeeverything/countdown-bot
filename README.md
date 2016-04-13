# Countdown Bot

A solver for the conundrums posed on the popular UK Channel 4 TV show ["Countdown"](www.channel4.com/programmes/countdown) (or, more risque, the [8 Out of 10 Cats does Countdown](www.channel4.com/programmes/8-out-of-10-cats-does-countdown
) variant).

More generally this solves the problem of taking a random string of characters and finding the words that can created from them, ordered by length (longest being best).

This more general case can be used to solve anagrams, or as a basis for a spell checker (with some distance measurement such as the [Levenshtein distance](https://en.wikipedia.org/wiki/Levenshtein_distance), for example).

The matches are only as good as the dictionary available, and here I use a [58,000 English word list](http://www.mieliestronk.com/wordlist.html), with only entries of length <= 9 (the max allowed in Countdown), compiled into the dictionary used for lookups. It's not intended to be exhaustive, but does work well for most test cases.

### Run me

```
$ cd src
$ php countdown.php somechars
```

Running without an argument will use a random string of 9 characters.

Strings are truncated to 9 chars in length and lower-cased, the max in a game of Countdown.

### TODO

- Put in Composer and add a after-install script to gen the dictionary rather than include in the repo

## Power Sets. Or, "How to win at Countdown and Scrabble" :)

I like Countdown, both the letters and numbers rounds, and my hat goes off to anyone who is even moderately good at it - I'm certainly not!

In the letters round the rules are quite simple: select a series of 9 vowels and consonants, then start the clock and find the longest word you can in 30 seconds. The winner is the team with the longest verifiable word.

#### Poor performance

Try as I might I personally struggle to rise above the 3 or 4 letter word mark on most occasions, it's frustrating but on the other hand it's led me to think about the problem and a way to solve it in code - so it's not all bad!

If you're similarly frustrated, or just curious, then read on. Or, if you just want to see results take a look at [countdown.codeeverything.com](http://countdown.codeeverything.com) and try some conundrums out for yourself.

#### Beating the clock: The dictionary

The first step along the road to beating the Countdown clock is to build a dictionary against which we can compare our sequence of letters.

I found a handy word list of 58,000 English words online and processed this into a useable structure, omitting any word > 9 characters long.

One key to resolving answers in our dictionary is to store words in some ordered fashion. In this case we don't care about the sequence of letters, only that they are there. So, we can take a word and sort its letters alphabetically - this gives two main benefits:

- The resulting dictionary can be sorted alphabetically for better lookup performance
- Any words that contain the same letters can be stored in one dictionary entry, which means we can get multiple candidate answers at a time

#### Beating the clock: The search

So, how do we go about finding all the words a sequence of letters could produce?

As it happens mathematics has the answer in the form of sets, and more importantly Power Sets.

So, what is a set? A set is a collection of values, you can think of it as a list. In the context of Countdown the list is all the letters in the conundrum.

Now we have a list of letters we need to know the different combinations they can be put into, using all the letters, then one less, then another less, all the way down until we have none left. I.e. for a set of 9 letters we want to find all the 9 letter words, then the 8 letter words, then the 7 letter words and so on.

Luckily Power Sets do exactly this! A power set is the set of all sub sets of a given set. That sounds a bit daunting, but its not really - here's an example:

Set = {1,2,3,4} 
Power Set = {}, {1}, {2}, {1,2}, {3}, {1,3}, {2,3}, {1,2,3}, {4}, {1,4}, {2,4}, {1,2,4}, {3,4}, {1,3,4}, {2,3,4}, {1,2,3,4}}


> ##### Remember the order

> Remember we ordered our dictionary words so that they were in alphabetical sequence? (e.g. "great" would be stored as "aegrt"), well since we did that we need to order our conundrum to.

#### Sounds like a lot of work

It does, but luckily the number of combinations of a set is calculated as ```2 ^ n```, where ```n = the length of the conundrum```, so since we have a max conundrum length of 9, the max combinations to test for a conundrum is _only_ ```2 ^ 9```, or ```512``` - not too bad, a computer will chew over that in no time.

#### The end

Now we have our dictionary and our power set of all possible combinations of letters from 9 letter words down to 1 (which is overkill obviously), we can simply check each against our dictionary and store any hits we get.

Once we have a list we can put the longest words at the front and return a result - **congratulations, you just beat the Countdown clock!** :)

