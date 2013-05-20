Date: 2013-05-20  
Title:  Dev_journal_entry_3 </br>
Published: true  
Type: post  
Excerpt:   

So my LAMP mysql database is broke. I've been trying to fix it for about a month and no luck. So I finally had a good idea to just use a VM for most of my local development needs. 

Enter Vagrant

The way I did was I already Oracle's VirtualBox downloaded along with Vagrant. I downloaded the lastes stable release wordpress. I cd in the directory with terminal and I downloaded the vagrant base box: 
	
	1. $ vagrant box add caseproof-lamp https://s3.amazonaws.com/caseproof/caseproof-lamp.box
	
	2. $ vagrant init caseproof-lamp

	3. $ vagrant up
	
With these commands it appears that this vagrant thing is working out for me with is really good!

So I went to localhost:8080/myphpadmin, I had to create a database called wordpress and follow the setup wizard when I went to localhost:8080.





References are as followed:

1. http://blairwilliams.com/2012/04/12/run-wordpress-locally-with-vagrant/
2. 

