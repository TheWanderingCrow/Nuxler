# This is a list of all the formats for different functions
## Groups
```
"type": "group"
"name": string
"enabled": bool
"items": array
"description": string
```

## Function
```
"type": "function"
"name": string,
"enabled": bool
```
Code files will be dynamically loaded based on name. If your function is named Kill, it will attempt to find Kill.js in the same directory. Spaces will be substituted for underscored like so: Kill Thing will look for Kill_Thing.js
NOTE: A subfolder in your directory tree will be considered a group, so group definitions are not nessesarily needed if following proper directory structure.

## Alias
```
"type": "alias"
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
"type": "trigger"
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
"type": "event"
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
