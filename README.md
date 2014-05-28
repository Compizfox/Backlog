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
- Multiple statuses (not just finished/not finished!)
- Support for DLC
- Notes for purchases, DLC or games
- Steam integration
  - Import games from Steam
  - Get playtime and icons/logos from Steam
- Stats page
- History

##### Purchases and games
Backlog is based around a purchase model; the idea is that when you buy a game, or a bundle with games (like a indie bundle), you add a purchase. You specify where you bought it, for how much and what games it contains. One purchase can hold multiple games (this is great for keeping track of bundles!), but a game can appear in multiple purchases. This is because sometimes you buy a bundle which contains a game you already have.

##### Statuses
Every game has a status attached, like:
- Finished
- Untouched
- Playing
- Gave up (boring/too hard)
- Unfinishable (multiplayer only)

### Demo
There's a demo available at http://backlog.tuxplace.nl.

### Installation

##### Prerequisites
- Webserver with PHP > 5.3 and mysqlnd driver
- MySQL

##### Instructions
Download a stable release or clone the development branch (bleeding edge!). You only need to extract the inner _backlog_ folder to the docroot. Create a MySQL database and user and import the SQL file. Enter the database details in _config.php_. If you want Steam integration, you'll also need to enter your SteamID and API key.

### Used tools and libraries
Bootstrap is written in PHP. The design is based on Bootstrap with the Bootswatch Slate theme. Charts are powered by ChartJS. Besides jQuery, it also uses jQuery UI.

### Database design
![](http://srv.tuxplace.nl/hosted/backlog_screenshots/Screenshot_7.png)

### Development status
As you might have guessed, Backlog is heavily in development. There is no stable/ready for use release yet. You should regard it as WIP/alpha.

This project wasn't originally intended for public distribution, but rather as an (small) school project. Hence the lack comments in the code and so on.

### Wiki
Don't forget to look at the [wiki](https://github.com/Compizfox/Backlog/wiki) for screenshots and a FAQ. 
