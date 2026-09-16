# PHP To-Do List
This project is a simple implementation of a To-Do list API which supports adding, deleting, and updating task for each user.
This project also has registry and login, impemented in it. \
Unfortunately for now, this project doesn't support good UI implementation and it's only something that works. Front work will be added as soon as possible.

## Installation Instruction
Installation process is the same for all Operating Systems.
1. Make sure you have PHP installed in your environment.
2. Clone the repository (you can also download the zip file):
```bash
https://github.com/DeathHashira/php-todo-list-mvc.git
```
3. Open your terminal inside directory and install the needed packages:
```bash
composer install
```
4. Create your `.env` file based on `.env.example` and then fill it with your database drivers info.
5. Run it in your `localhost`:
```bash
php -S localhost:8888 -t public/
```
6. Create the tables by implementing migrations. Make sure your database is running.
```bash
php bin/migrate.php init
php bin/migrate.php migrate
```
Now everything is up on your localhost.
## Usage
This project is only for educational purpose of understanding the simple implementation of MVC (Router included), written in raw PHP. \
Also has been attempted to not use packages, and most of mechanisms are raw implemented (not complete) to make the process of understanding each mechanism easier. \
Updates will be added and remaining bugs will be fixed.\
\
Note: The idea of this project is from [Roadmap.sh projects](https://roadmap.sh/projects/todo-list-api).
## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.