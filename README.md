Backlog
=======
Backlog: Game database

### What is Backlog?
Backlog is a solution for gamers who have too much games and can't keep track of them.

Backlog helps you answer a couple of questions:
- What games do I have?
- How many games do I still need to finish?
- How, and when, did I get that game and for how much?

### Features
- Keep track of purchases (dates, shops and prices)
- Multiple customizable statuses
- Support for DLC
- Notes for purchases, DLC or games
- Steam integration
  - Import games from Steam
  - Get playtime and icons/logos from Steam
- Statistics
- Playthroughs

##### Purchases and games
Backlog is based around a purchase model; the idea is that when you buy a game, or a bundle with games (like an indie bundle), you add a purchase. You specify where you bought it, for how much and what games it contains. One purchase can hold multiple games (this is great for keeping track of bundles!), but a game can appear in multiple purchases. This is because sometimes you buy a bundle which contains a game you already have.

##### Statuses
Every game has a status attached, like:
- Finished
- Untouched
- Playing
- Gave up
- Unfinishable (multiplayer only)

### Development status
##### 2016-9-7
Because the codebase of the current version of Backlog is old, crappy and unmaintainable, I'm working on a Laravel-based rewrite of Backlog. You can follow the progress at https://github.com/Compizfox/Backlog/tree/rewrite. When the rewrite has all the features of the old version and is ready for use, it will become the main branch of the project.

##### 2015-1-27 - Backlog v0.4
Backlog is pretty usuable in this state. It still hasn't been thoroughly tested though. Although most features are there, you should still regard it as beta.

This project wasn't originally intended for public distribution, but rather as an (small) school project. Hence the lack comments in the code and so on.

##### Start of project
As you might have guessed, Backlog is heavily in development. You should regard it as WIP/alpha. Even in the releases, there are undoubtedly bugs I missed. If you encounter a bug, please report it using the [issues page on Github](https://github.com/Compizfox/Backlog/issues)

### Installation

##### Prerequisites
- Webserver with PHP > 5.3 and mysqlnd driver
- MySQL

##### Instructions
Download a stable release or clone the development branch (bleeding edge!). You only need to extract the inner _backlog_ folder to the docroot. Create a MySQL database and user and import the SQL file. Enter the database details in _config.php_. If you want Steam integration, you'll also need to enter your SteamID and API key.

### Used tools and libraries
Backlog is written in PHP and uses the Laravel framework.
    
In addition, Backlog also uses the following front-end frameworks:

- Javascript library: jQuery
- Front-end framework: Bootstrap
- Bootstrap theme: Bootswatch Slate
- Icon packs: Glyphicons and Font Awesome

### Wiki
Don't forget to look at the [wiki](https://github.com/Compizfox/Backlog/wiki) for screenshots and a FAQ. 