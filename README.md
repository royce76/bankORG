# bankORG

## Week 19 - collaborative project on Symfony 5


### Project due: 
A Symfony banking applicationIf the evolution of your application towards an object model with integration of the MVC pattern has allowed you to correct the bugs previously reported and to improve the maintainability of the application, too many maintenance issues are still present. 
Indeed, many developers have succeeded one another on the project, each bringing their own style of code and today the source code has lost coherence making its evolution difficult. Similarly, performance problems during big load increases are felt. 
It is for all these reasons that your project manager has decided to migrate the application to the Symfony framework.

### Reminder of the functional specifications:
- The application is only accessible to connected users. 
- When a non connected user goes to the application he is redirected to a connection page with a form. 
- A user connects using an email address and a password. 
- A connected user can disconnect. 
- Once connected, the user only sees his personal bank accounts. 
- When the user clicks on a bank account, he or she is taken to a dedicated account page where he or she can see the account information and the last transactions made on the account.
- Via a dedicated page a user can create a new personal account with the help of a form. Once created the account appears on the home page. Please note that the account must meet the minimum requirements for account creation (correct type and amount). 
- The user can make deposits or withdrawals to the account of his choice. The amount of the account is then updated and a new transaction is recorded on the account. 

In addition to these specifications, you will try to:
- populate the database using fixtures.
- validate the data entered in the forms using the validator.

### Some tips for project management: 
- Make sure you have a coherent UseCase or tree structure. 
- Choose a project manager Take the time to prepare your Kanban and carefully divide the tasks by estimating their time and date of completion. 
- Create a work schedule (possibly a Gant chart to ensure the sequence of tasks). 
- Hold at least one meeting at the beginning and end of the day to review the work done and to be done. 
- Draw up your DBD diagram, class and entity diagram + migrations together in order to have a common base.
- Don't exchange anything by mail or key, everything goes through GitHub.
- Don't forget to pull before push-Always check if you have retrieved migrations because you have to run them.
- Do not modify the DB manually, you modify the entities you migrate.
- Run an update composition regularly.

### To go further:
- Write some simple unit tests to check the application's functioning.
- Deploy your application on the Heroku cloud service in order to have an online version.
- The user can make transfers from one account to another, which creates two new operations.
- Error messages may be displayed on the different forms when they are incorrectly filled in.
- The user can delete the accounts that belong to him.
- On the home page, for each account the user sees the last operation on that account.
- Users can access their profile page and update their personal information.

Translated with www.DeepL.com/Translator (free version)