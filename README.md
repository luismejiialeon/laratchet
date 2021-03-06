##Laratchet
A ratchet push implementation for Laravel 5 - !!Still under development!!

Features: 

- Send push notifications to a broadcast channel
- Send push notifications to a collection (closed group) of laravel users

### How to install
Laratchet was submitted to composer. In order to install you have to require

`"barrot/laratchet" : "dev-master"`

and run `composer install ` so composer can do it's job.

Finally you habe to include the package service provider in `app/providers/AppServiceProvider`

    $this->app->register('Barrot\Laratchet\ServiceProviders\LaratchetServiceProvider');



### Dependencies
Laratchet has internal dependencies to the following packages: `"react/zmq": "0.2.*|0.3.*"` and `"cboden/ratchet": "0.3.*"`. Also the `php_zmq` extension is required.

If you need help installing you can visit: 

[http://jackbennett.co/2013/11/using-omq-zeromq-with-vagrant-and-virtualbox/](http://jackbennett.co/2013/11/using-omq-zeromq-with-vagrant-and-virtualbox/ "Build ZeroMQ with vagrant")

[http://alexandervn.nl/2012/05/03/install-zeromq-php-ubuntu/ ](http://alexandervn.nl/2012/05/03/install-zeromq-php-ubuntu/  "Build ZeroMQ for Linux in general")

[http://zeromq.org/intro:get-the-software](http://zeromq.org/intro:get-the-software "Vendors website with downloads for linux and windows")


### Components
#### Server Command
Laratchet comes with an artisan command to start the push server. The socket urls a preconfigured in the package config file. You can publish the configuration to app/config/laratchet by using `artisan vendor:publish` (This will also publish the package migration (for session storage) and views). The command is registered in the laratchet namespace, so just call 

	artisan laratchet:serve 

and the server should be up and running.

#### First Test Client
The package comes with kickstart routes and controller actions. Just navigate to `{YOURPROJECTURL}/laratchet/client` and see what is happening.

#### Sending push messages

##### Broadcast to a channel

###### Client setup

The client js code uses autobahn to handle the websocket request. There is a full example online http://socketo.me/docs/push. So include the library in your document `<script src="http://autobahn.s3.amazonaws.com/js/autobahn.min.js"></script>`.

	var count = 0;
    var conn = new ab.Session('{{Config::get('laratchet.clientPushServerSocket')}}',
	    function() {
		    conn.subscribe('{{(Config::get('laratchet.demoPushChannel'))}}', function(topic, data) {
		    console.log('Got push nr. '+count);
		    count++;
	    });
	    },
	    function() {
	    	console.warn('WebSocket connection closed');
	    },
    {'skipSubprotocolCheck': true}
    );

Just subscribe to a channel and listen for push messages.

###### Server Setup
Laratchet comes with a Facade that is auto registered by the package service provider. You can push data to a channel by using the push method 
  
    Laratchet::push(
	    \Config::get('laratchet.demoPushChannel'),
	    ['myKey' => 'myValue']
    );


##### Collection of users / single users

###### Client Setup

The code below is just a basic example. Connect to the push server and respond to server messages.

     var conn = new WebSocket('{{Config::get('laratchet.clientPushServerSocket')}}');
     conn.onmessage = function(event) {
     	console.log(event.data);
     }

  

  
###### Server Setup
  
The server setup for this case is more complex because we have to match a push connection to the users laravel session. **To share sessions the laratchet server and laravel application have to run under the same domain**. Otherwise the laravel session is not available to the push server.

**What we will do:**

- If a user connects to the push server we read laravels session cookie and bind the ID to the push connection
- While using the application we store the current users session ID in relation to his user_id in the database
- By sending a push message to a collection of users the package resolves the current session id for each user and identifies the matching push connections. After that a push message is send to each matching connection.

**How we do this:**

First open your laravels .env file and set your session driver to database

    SESSION_DRIVER = database

The database driver needs a sessions table to store the session information. This table can be generated by use of 

	php artisan session:table

In addition we need a user\_id column, so add this to the migration. Alternatively while using php artisan vendor:publish the package ships a session migration that has the user\_id column. Now migrate the database.

Finally we have to ensure that the session id is kept in sync with the user_id. Laratchet comes with a route filter that can be attached to your auth protected routes and syncs the session db storage.

    Route::group(['before' => 'auth|syncSession'],function(){
    
      // Your protected routes
    });

To access a users session relation from the \App\User model you can add the packages UserSessionTrait. 

    use Barrot\Laratchet\Traits\UserSessionTrait;

If we want to send a push message to a closed group of users we use:

	$recipients = \App\User::all();
	//$recipient = \App\User::first();

    Laratchet::message(
    	['myKey' => 'myValue'], 
    	$recipients
	);

In addition the message method accepts a single \App\User object.
