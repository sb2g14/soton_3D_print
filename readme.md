# 3dprint.clients.soton.ac.uk web site 
[![License](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)
[![GitHub contributers](https://img.shields.io/github/contributors/sb2g14/soton_roles.svg)](https://github.com/sb2g14/soton_roles/graphs/contributors)
[![GitHub issues](https://img.shields.io/github/issues/sb2g14/soton_roles.svg)](https://github.com/sb2g14/soton_roles/issues)

## Installtion instruction
...will be added...

## Database updates
### Linux/MacOS
- Dump lates database with mysql dump 
```mysqldump -u root -p[root_password] [database_name] > dumpfilename.sql```
- Feed the dump file into the working database
```mysqldump -u root -p[root_password] [database_name] < dumpfilename.sql```
- Alternatively, edit the sql file and add `USE [database_name];` in the beginning.
  You can then run
```mysql -u root -p < dumpfilename.sql```
### Windows
Do the same but you may encounter issues with ">" and "<". Look for substitutions online. Possibly "-e"

## See it live:
http://3dprint.clients.soton.ac.uk/printers/index

## Get Help on Libraries used:
- *Laravel* as the PHP framework
- *Bootstrap*
- *jQuery*
- *Carbon* for PHP DateTime variables (http://carbon.nesbot.com/docs/)
- *Charts* by ConsoleTV for easily creating charts in Laravel (https://github.com/ConsoleTVs/Charts/tree/5.4.0/docs/5)

## TODO:
- [ ] Remember to fulfill all license requirements for the pulled packages ASAP...
- [ ] Add Laravel installation instructions/ link to this readme so future programmers can set up their own environment

## License

The [MIT license](http://opensource.org/licenses/MIT).


