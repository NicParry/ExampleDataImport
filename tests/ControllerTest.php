<?php

class ControllerTest extends TestCase {

    public function testSubmitClientInfoDifferentDepartments()
    {
        $content = "Road\tRunner\trrunner@acme.com\tm\tGags\tB Bunny\tmartin@thornhill.co.za\n";
        $content .= "Wiley\tCoyote\twcoyote@acme.com\tm\tSecurity\tE Fudd\tsecurity@acme.com";

        $response = $this->call('POST', '/client-info', array(), array(), array(), array(), $content);

        $this->assertResponseStatus(201);
        $this->assertEquals('Client information successfully stored for 2 people and 2 departments', $response->getContent());
    }

    public function testSubmitClientInfoSameDepartments()
    {
        $content = "Road\tRunner\trrunner@acme.com\tm\tSecurity\tE Fudd\tsecurity@acme.com\n";
        $content .= "Wiley\tCoyote\twcoyote@acme.com\tm\tSecurity\tE Fudd\tsecurity@acme.com";

        $response = $this->call('POST', '/client-info', array(), array(), array(), array(), $content);

        $this->assertResponseStatus(201);
        $this->assertEquals('Client information successfully stored for 2 people and 1 departments', $response->getContent());
    }

    public function testSubmitClientInfoError()
    {
        $content = "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t";
        $content .= "Wiley\tCoyote\twcoyote@acme.com\tm\tSecurity\tE Fudd\tsecurity@acme.com";

        $response = $this->call('POST', '/client-info', array(), array(), array(), array(), $content);

        $this->assertResponseStatus(400);
        $this->assertEquals('Error while processing data', $response->getContent());
    }

    public function tearDown()
    {
        //no teardown
    }
}
