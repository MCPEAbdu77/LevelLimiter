# LevelLimiter
<a href="https://poggit.pmmp.io/p/LevelLimiter"><img src="https://poggit.pmmp.io/shield.state/LevelLimiter"></a>

A PocketMine-MP plugin which let's you whitelist specific commands on specific worlds.

# Config.yml 
Set up the commands and the whitelisted world(s) on which the specific command will work on.
 - command1:
     - "world1"
     - "world2"
 - command2:
     - "world3"
 
# Permissions
 Operators will be able to bypass this restriction by default. Users with `levellimiter.bypass` can bypass this restriction.
 If you want to grant access to a group/user to bypass the restriction on a specific world, add `levellimiter.bypass.<world>`.
 
 `<world>` denotes the world name. 
 
 Example: 
  - `levellimiter.bypass.flat` grants the user/group to bypass restrictions on `flat` world.
 
 If you want to grant access to a group/user a specific command on a specific world, add `levellimiter.bypass.<world>.<command>`.
 Example:
  - `levellimiter.bypass.flat.pay` grants the user/group to use the `/pay` command on `flat` world.

# Contact

 - Discord: MCA7#1245
