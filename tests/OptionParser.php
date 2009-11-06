<?php

require_once 'PHPUnit/Framework.php';

require_once dirname(dirname(__FILE__)) . '/lib/OptionParser.php';

class OptionParserTest extends PHPUnit_Framework_TestCase
{

    public function testInvalidOption()
    {
        $op = new OptionParser;

        $this->setExpectedException('Exception');

        $args = array('-', '-c');
        $op->parse($args);
    }

    public function testArguments()
    {
        $op = new OptionParser;
        $op->addRule('a:');

        $args = array('progname', 'word', '-a', 'a string');
        $op->parse($args);

        $this->assertEquals($op->getProgramName(), 'progname');
        $this->assertEquals($op->a, 'a string');
        $this->assertEquals($args, array('word'));

        $op->setConfig(OptionParser::CONF_DASHDASH);

        $args = array('progname', '-a', '--', '-a', 'word');
        $op->parse($args);

        $this->assertTrue($op->a === true);
        $this->assertEquals($args, array('--', '-a', 'word'));
    }

    public function testShortOption()
    {
        $op = new OptionParser;
        $op->addRule('a');
        $op->addRule('b');

        $this->assertFalse(isset($op->a));
        $this->assertFalse(isset($op->b));

        $args = array("-", "-a", "-b");
        $op->parse($args);

        $this->assertTrue(isset($op->a));
        $this->assertTrue(isset($op->b));
        $this->assertTrue($op->a);
        $this->assertTrue($op->b);
    }

    public function testShortOptionCluster()
    {
        $op = new OptionParser;
        $op->addRule('a');
        $op->addRule('b');

        $this->assertFalse(isset($op->a));
        $this->assertFalse(isset($op->b));

        $args = array("-", "-ab");
        $op->parse($args);

        $this->assertTrue(isset($op->a));
        $this->assertTrue(isset($op->b));
        $this->assertTrue($op->a);
        $this->assertTrue($op->b);
    }

    public function testShortOptionWithParameter()
    {
        $op = new OptionParser;
        $op->addRule('a|b:');
        $op->addRule('c::');

        $this->assertTrue($op->isOptional('a'));
        $this->assertTrue($op->isOptional('b'));
        $this->assertTrue($op->isRequired('c'));

        $args = array("-", "-a", "1", "-c", "string");
        $op->parse($args);

        $this->assertEquals($op->a, 1);
        $this->assertEquals($op->b, 1);
        $this->assertEquals($op->c, 'string');

        $this->setExpectedException('Exception');

        $args = array('-', '-c');
        $op->parse($args);
    }

    public function testLongOption()
    {
        $op = new OptionParser;
        $op->addRule('verbose');
        $op->addRule('quiet');

        $args = array("-", "--verbose");
        $op->parse($args);

        $this->assertTrue($op->verbose);
        $this->assertFalse($op->quiet);
    }

    public function testLongOptionWithParameter()
    {
        $op = new OptionParser;
        $op->addRule('verbose');
        $op->addRule('dir-name::');

        $args = array("-", "--verbose=yes", '--dir-name', 'lib/test/dir');
        $op->parse($args);

        $this->assertEquals($op->verbose, 'yes');
        $this->assertEquals($op->getOption('dir-name'), 'lib/test/dir');

        $this->setExpectedException('Exception');

        $args = array('-', '--dir-name');
        $op->parse($args);
    }

}

