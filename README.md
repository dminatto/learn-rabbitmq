
###Important to remember

- A producer is a user application that sends messages.

- A queue is a buffer that stores messages.

- A consumer is a user application that receives messages.

The core idea in the messaging model in RabbitMQ is that the producer never sends any messages directly to a queue. Actually, quite often the producer doesn't even know if a message will be delivered to any queue at all.
Instead, the producer can only send messages to an exchange.On one side it receives messages from producers and the other side it pushes them to queues. The exchange must know exactly what to do with a message it receives.
The rules for that are defined by the exchange type.

Exchange types available: _direct, topic, headers and fanout_

- **Direct:**
- **Topic:**
- **Header:**
- **Fanout:** Broadcasts all the messages it receives to all the queues it knows.

Direct: A direct exchange delivers messages to queues based on a message routing key. In a direct exchange, the message is routed to the queues whose binding key exactly matches the routing key of the message. If the queue is bound to the exchange with the binding key pdfprocess, a message published to the exchange with a routing key pdfprocess is routed to that queue.
Fanout: A fanout exchange routes messages to all of the queues that are bound to it.
Topic: The topic exchange does a wildcard match between the routing key and the routing pattern specified in the binding.
Headers: Headers exchanges use the message header attributes for routing.

###CONCEPTS

- **Producer:** Application that sends the messages.

- **Consumer:** Application that receives the messages.

- **Queue:** Buffer that stores messages.

- **Message:** Information that is sent from the producer to a consumer through RabbitMQ.

- **Connection:** A connection is a TCP connection between your application and the RabbitMQ broker.

- **Channel:** A channel is a virtual connection inside a connection. When you are publishing or consuming messages from a queue - it's all done over a channel.

- **Exchange:** Receives messages from producers and pushes them to queues depending on rules defined by the exchange type. To receive messages, a queue needs to be bound to at least one exchange.

- **Binding:** A binding is a link between a queue and an exchange.

- **Routing key:** The routing key is a key that the exchange looks at to decide how to route the message to queues. The routing key is like an address for the message.

- **AMQP:** AMQP (Advanced Message Queuing Protocol) is the protocol used by RabbitMQ for messaging.

- **Users:** It is possible to connect to RabbitMQ with a given username and password. Every user can be assigned permissions such as rights to read, write and configure privileges within the instance. Users can also be assigned permissions to specific virtual hosts.

- **Vhost, virtual host:** A Virtual host provides a way to segregate applications using the same RabbitMQ instance. Different users can have different access privileges to different vhost and queues and exchanges can be created, so they only exist in one vhost.




##Access and Permissions

- None

No access to the management plugin

- management

Anything the user could do via messaging protocols plus:

List virtual hosts to which they can log in via AMQP

View all queues, exchanges and bindings in "their" virtual hosts

View and close their own channels and connections

View "global" statistics covering all their virtual hosts, including activity by other users within them


- policymaker

Everything "management" can plus:

View, create and delete policies and parameters for virtual hosts to which they can log in via AMQP

- administrator

Everything "policymaker" and "monitoring" can plus:
	
Create and delete virtual hosts

View, create and delete users

View, create and delete permissions

Close other users's connections



#### Useful commands


>
>_List the exchanges on the server_
>
>`sudo rabbitmqctl list_exchanges`
> 

>_List existing bindings_
>
> `rabbitmqctl list_bindings`
>

>save logs to a file
>
>`php receive_logs.php > logs_from_rabbit.log`
>


##

#### Test Source 
 
####Tutorial one:

**Goal**: Create a basic producer that sends a single message, and a consumer that receives messages and prints them out.

`php send.php`
 
`php receive.php` 

####Tutorial two:

**Goal**: Create a Work Queue that will be used to distribute time-consuming tasks among multiple workers.

The main idea behind Work Queues is to avoid doing a resource-intensive task immediately and having to wait for it to complete. Instead we schedule the task to be done later. We encapsulate a task as a message and send it to a queue. A worker process running in the background will pop the tasks and eventually execute the job. When you run many workers the tasks will be shared between them.

This concept is especially useful in web applications where it's impossible to handle a complex task during a short HTTP request window.

`php new_task.php "A very hard task which takes two seconds.."`

`php worker.php`

####Tutorial three:

**Goal:** Implements the "publish/subscribe" pattern built a simple log system

`php receive_logs.php`

`php emit_log.php "info: This is the log message"`


####Tutorial four: 

**Goal:** Direct some messages to log file 

>specify the type of message that will be saved in log (just warning and error)
>
>`php receive_logs_direct.php warning error > logs_from_rabbit.log`
>
>specify the typo of recive 
>
>`php receive_logs_direct.php info warning error`
>
>specify the type of emit
>
>`php emit_log_direct.php error "Run. Run. Or it will explode."`
>
>

####Tutorial five: 

####Tutorial six: 


##

###### Useful Links 

[Good tutorial to Installation](https://cmatskas.com/getting-started-with-rabbitmq-on-windows/)

[Tour to admin - PT/Br ](https://medium.com/dockerbr/rabbitmq-com-docker-conhecendo-o-admin-cc81f3f6ac3b)

[Documentation RabbitMq](https://www.rabbitmq.com/documentation.html)

[RabbitMQ for beginners - What is RabbitMQ?](https://www.cloudamqp.com/blog/2015-05-18-part1-rabbitmq-for-beginners-what-is-rabbitmq.html)

