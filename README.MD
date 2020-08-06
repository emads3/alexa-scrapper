# Alexa Scraper

### Please note that extracting text using `Regex` is heavy load regrading to performance issues. Read below to know more about optimizations:
#### Alternatives to that:

1. Using native PHP DOM parser
    * Problems: load page from Alexa is not guaranteed to be valid HTML syntax which will cause the parser to fail
2. Using another Dom parser library like: ‘paquettg/php-html-parser’
    * Problems: After checking the insights if the parser, It’s also heavier than Regex solution
3. Using Regex directly
    * Problems: using regex directly on a document with thousands of words and extracting only one element can cost thousands of regex step and may exceed which is also heavy but is not that bad.
4. Sanitizing string before using regex using PHP build-in string functions which are very efficient then using regex. This solution reduces the load from tens of thousands to hundreds- which is the optimal solution.
