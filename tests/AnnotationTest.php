<?php

namespace Kaplarn\Annotation\Tests;

use Kaplarn\Annotation\Annotation;

/**
 * @author Káplár Norbert <kaplarnorbert@webshopexperts.hu>
 */
class AnnotationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Kaplarn\Annotation\Annotation::has
     * @dataProvider provider
     * 
     * @param String $docBlock
     */
    public function testHas($docBlock)
    {   
        $parser = new Annotation($docBlock);
        
        $this->assertTrue($parser->hasService());        
        $this->assertTrue($parser->hasName());
        $this->assertTrue($parser->hasLength());
        $this->assertTrue($parser->hasReadOnly());
        $this->assertFalse($parser->hasAuthor());
    }
    
    /**
     * @covers \Kaplarn\Annotation\Annotation::get
     * @dataProvider provider
     * 
     * @param String $docBlock
     */
    public function testGet($docBlock)
    {
        $parser = new Annotation($docBlock);
                
        $this->assertEquals(true, $parser->getService());
        $this->assertEquals('Class Name', $parser->getName());
        $this->assertEquals(15, $parser->getLength());
        $this->assertEquals(false, $parser->getReadOnly());
        $this->assertEquals(null, $parser->getAuthor());
    }
    
    /**
     * @return []
     */
    public function provider()
    {
        return
            [
                [
                    '/**' .
                    ' * [' .
                    ' *      \'service\' => true,' .
                    ' *      \'name\' => "Class Name",' .
                    ' *      \'length\' => 15,' .
                    ' *      \'readOnly\' => false ' .
                    ' * ]'.
                    ' * ' .
                    ' * @author Káplár Norbert <kaplarnorbert@webshopexperts.hu>' .
                    ' */'
                ],
                [
                    '/**' .
                    ' * [\'service\' => true, \'name\' => "Class Name", \'length\' => 15, \'readOnly\' => false]'.
                    ' * ' .
                    ' * @author Káplár Norbert <kaplarnorbert@webshopexperts.hu>' .
                    ' */'
                ]
            ];
    }
}
