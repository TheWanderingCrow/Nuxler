# This is a list of all the formats for different functions
## Directory Structure
Nuxler uses a specific directory structure to compile everything in a nice manner.
```
/exampleProject
│   nuxspec
│
└───src
    ├───aliases
    │   └───GroupName
    │           aliases.json
    │           code.js
    │
    |───triggers
    |   └───GroupName
    |           code.js
    |           triggers.json
    |───functions
    |   └───GroupName
    |           code.js
    |           functions.json
    |───events
    |   └───GroupName
    |           code.js
    |           events.json
```
GroupName may be omited to place everything into the root of the project, this is not recommended however.
## Nuxspec File
This file contains meta-information for your package, and is optional. The Nuxspec structure is below and all fields are optional:
```
{
  "package": string,
  "version": string,
  "author": string,
  "description": string
}
```
## Groups
```
"name": string
"enabled": bool
"items": array
```
NOTE: A subfolder in your directory tree will be considered a group, so group definitions are not nessesarily needed if following proper directory structure.

## Function
```
"name": string,
"enabled": bool
```
Code files will be dynamically loaded based on name. If your function is named Kill, it will attempt to find Kill.js in the same directory. Spaces will be substituted for underscored like so: Kill Thing will look for Kill_Thing.js

## Alias
```
"name": string
"enabled": bool
"text": string
"matching": string
"whole_words": bool
"case_sensitive": bool
```
Text is what the alias will match with. Valid matching types are "begins", "regexp", and "exact".

## Trigger
```
"name": string
"enabled": bool
"text": string
"matching": string
"whole_words": bool
"case_sensitive": bool
```
Text is what the trigger will match with. Valid matching types are "substring", "begins", "exact", and "regexp".

## Event
```
"name": string
"enabled": bool
"evtype": string
"evsubtype": string
```
So far I have only seen this used to handle GMCP events, but others may come later. Thus, the only valid evtype currently is "GMCP", and evsubtype is the specific event such as "Char.Vitals"

# Developer notes
The dynamically loaded code goes into an "actions": [] block in all objects, the structure of this block is as follows.
```
{
    "type": "script",
    "enabled": true,
    "script": "//Enter script here"
}
```
Folder names reveal the types the script will assign stuff too, therefor anything in the aliases folder will have "type": "alias".
Valid types are: "alias", "event", "function", "trigger".
If enabled is omited in a .json file, then the object is assumed to be enabled.

### Aliases
whole_words defaults to true
case_sensitive defaults to false

### Triggers
whole_words defaults to true
case_sensitive defaults to false