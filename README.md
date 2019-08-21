
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


Bindings: A binding is a relationship between an exchange and a queue. This can be simply read as: the queue is interested in messages from this exchange.

##

#### Useful commands


>
>_List the exchanges on the server_
>
>`sudo rabbitmqctl list_exchanges`
> 

>_List existing bindings_
>
>`rabbitmqctl list_bindings`
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

[Documentation RabbitMq](https://www.rabbitmq.com/documentation.html)
