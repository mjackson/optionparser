# Overview

OptionParser is a parser for command-line options for PHP. It supports both short and long options, optional and/or required parameter checking, automatic callback execution, and pretty printing of usage messages.

# Usage

First create a parser object and then use it to parse your arguments. Examples explain it best:

    $parser = new OptionParser;
    // add a rule that looks for the short "a" flag
    $parser->addRule('a');
    // add a rule that looks for the long "long-option" flag
    $parser->addRule('long-option');
    // add a rule that looks for the short "b" flag or long "big" flag
    $parser->addRule('b|big');
    // to indicate an optional parameter, use a colon after the flag name
    $parser->addRule('c:');
    // likewise, to indicate a required parameter use two colons
    $parser->addRule('d|debug::');
    // add a description for a rule that can be used later in a usage message
    $parser->addRule('e', 'The description for flag e');
    // or use a user-defined callback function that will be called when that
    // flag is used. the function will be passed the parameter that was given
    // to the flag, or true if the flag is optional and no parameter was used
    $parser->addRule('error-reporting', 'set_error_reporting');

Next, parse your arguments. This function can be called multiple times with the same parser to parse multiple sets of arguments if desired. Note: This function will throw an exception if the user has specified invalid flags. Also, if no arguments are specified here the global `$argv` argument will be used.

    try {
        $parser->parse();
    } catch (Exception $e) {
        die("Error parsing arguments: " . $e->getMessage());
    }

A more helpful error message might be to show the user the options that she can use to run your program:

    $parser->addHead("Usage: myprog [ options ]\n");
    try {
        $parser->parse();
    } catch (Exception $e) {
        die($parser->getUsage());
    }

# Examples

All scripts in the examples directory are designed to be run on a Unix/Linux machine as executables like this:

    $ ./copy

If you would like to run the examples on Windows, simply open the file and delete the first line. Then, use the php interpreter directly:

    $ php copy

# Tests

OptionParser uses the [PHPUnit](http://www.phpunit.de/) unit testing framework to test the code. In order to run the tests, do the following from the project root directory:

    $ phpunit tests/OptionParser.php

# Credits

OptionParser draws inspiration from several other option parsers including [GNU getopt](http://www.gnu.org/software/libc/manual/html_node/Getopt.html), Ruby's [OptionParser](http://raa.ruby-lang.org/project/optionparser/), and [Zend_Console_Getopt](http://framework.zend.com/manual/en/zend.console.getopt.html).

# Requirements

OptionParser requires PHP version 5 or greater.

<small>OptionParser is copyright 2009 Michael J. I. Jackson.</small>


