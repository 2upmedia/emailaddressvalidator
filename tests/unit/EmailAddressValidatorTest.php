<?php
namespace _2UpMedia;

class EmailAddressValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $email
     * @dataProvider getEmailAddresses
     */
    public function testAddUser($email)
    {
        $this->assertTrue($this->isValidEmail($email));
    }

    public function testXssInjectedEmail()
    {
        $email = '<script>window.alert("hello");</script>hello@gmail.com';

        $this->assertFalse($this->isValidEmail($email));
    }

    public function testAccentedCharacters()
    {
        $this->markTestSkipped(__METHOD__);

        $email = 'üñîçøðé@example.com';

        $this->assertTrue($this->isValidEmail($email));
    }

    public function getEmailAddresses()
    {
        return array(
            array('jorge@2upmedia.com'),
            array('michael@squiloople.com'),
            array('very.common@example.com'),
            array('a.little.lengthy.but.fine@dept.example.com'),
            array('disposable.style.email.with+symbol@example.com'),
            array('user@[IPv6:2001:db8:1ff::a0b:dbd0]'),
            array('"much.more unusual"@example.com'),
            array('"very.unusual.@.unusual.com"@example.com'),
            array('"very.(),:;<>[]\".VERY.\"very@\ \"very\".unusual"@strange.example.com'),
            array('postbox@com'),
            array('admin@mailserver1'),
            array("!#$%&'*+-/=?^_`{}|~@example.org"),
            array('"()<>[]:,;@\\"!#$%&\'*+-/=?^_`{}| ~.a"@example.org'),
            array('" "@example.org'),
        );
    }

    /**
     * @param $email
     * @return bool
     */
    protected function isValidEmail($email)
    {
        return (new EmailAddressValidator($email, EmailAddressValidator::RFC_5322))->isValid();
    }
}
 