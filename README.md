#Welcome to BeGame
##This is a message for our developers


###PLEASE READ THIS WHEN YOU'RE ADDING QUESTIONS


After long deliberation, the most efficient way to add questions turned out to be just to add them in the interface we programmed. When you're done adding questions, click the "Export database" button. This loads the current questions in your database to the 'VRAAG.json' file in the root folder of the project. 
When you run the command 'bin/console doctrine:fixtures:load', the current VRAAG.json will be loaded in the database. 
