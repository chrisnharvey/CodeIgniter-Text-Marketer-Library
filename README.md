CodeIgniter Text Marketer Library
=================================

_Deprecated: Looking for a new maintainer for this package. Open an issue if interested._

A library for CodeIgiter that allows you to send text messages (SMS) via the Text Marketer SMS gateway.

Usage
-----
	$this->load->library('textmarketer');
	$this->textmarketer->send('07777777777', 'Hello world!', 'Chris');
