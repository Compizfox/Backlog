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
- Keep track of playthroughs
- Multiple customizable statuses
- Support for DLC
- Notes for purchases, DLC or games
- Steam integration
  - Import games from Steam
  - Get playtime and icons/logos from Steam
- Statistics

##### Purchases and games
Backlog is based around a purchase model; the idea is that when you buy a game, or a bundle with games (like an indie bundle), you add a purchase. You specify where you bought it, for how much and what games it contains. One purchase can hold multiple games (this is great for keeping track of bundles!), but a game can appear in multiple purchases. This is because sometimes you buy a bundle which contains a game you already have.

##### Statuses
Every game has a status attached, like:
- Finished
- Untouched
- Playing
- Gave up
- Unfinishable (multiplayer only)

##### Playthroughs
Every game or DLC can have one or multiple playthroughs. You can create a playthrough when you start playing a game and easily see which games are started but unfinished. You can also see a history of playthroughs, including start and and data and optional notes.

### Development status
##### **2016-09-15**
The most important features of the new Laravel-based rewrite of Backlog are working and the `rewrite` branch will be set as the default branch. You can track the current development progress [here](https://github.com/Compizfox/Backlog/projects/1).

This is still beta, however, and the legacy branch will be more stable and complete for the time being.

##### **2016-09-07** - Start of rewrite
Because the codebase of the current version of Backlog is old, crappy and unmaintainable, I'm working on a Laravel-based rewrite of Backlog. You can follow the progress at https://github.com/Compizfox/Backlog/tree/rewrite. When the rewrite has all the features of the old version and is ready for use, it will become the main branch of the project.

##### **2015-01-27** - Backlog v0.4
Backlog is pretty usable in this state. It still hasn't been thoroughly tested though. Although most features are there, you should still regard it as beta.

This project wasn't originally intended for public distribution, but rather as an (small) school project. Hence the lack comments in the code and so on.

##### **2014-05-16** - Start of project
As you might have guessed, Backlog is heavily in development. You should regard it as WIP/alpha. Even in the releases, there are undoubtedly bugs I missed. If you encounter a bug, please report it using the [issues page on Github](https://github.com/Compizfox/Backlog/issues)

### Used tools and libraries
Backlog is written in PHP and uses the Laravel framework.
    
In addition, Backlog also uses the following front-end frameworks:

- Javascript library: jQuery
- Front-end framework: Bootstrap
- Bootstrap theme: Bootswatch Slate
- Icon packs: Glyphicons and Font Awesome

### Wiki
Don't forget to look at the [wiki](https://github.com/Compizfox/Backlog/wiki) for screenshots and a FAQ. 