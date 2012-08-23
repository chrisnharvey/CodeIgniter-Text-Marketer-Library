CodeIgniter Text Marketer Library
=================================
A library for CodeIgiter that allows you to send text messages (SMS) via the Text Marketer SMS gateway.

Usage
-----
	$this->load->library('textmarketer');
	$this->textmarketer->send('07777777777', 'Hello world!', $from = 'Chris');