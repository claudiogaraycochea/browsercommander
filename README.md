# Browser Commander

Is a Browser "File System". You can navigate, create, delete and rename files or folders in a public folder.


## Getting Started

These instructions will get you a copy of the project up and be running on your local machine for development and testing purposes.


### Prerequisites

For run the project you need install the Node JS and Yarn.

[Download and install Node JS](https://nodejs.org/es/download/) 

Install Yarn:
```
$ npm install -g yarn
```

## Build with
The project requires 2 environments, API for "Virtual Drive" and "Front End".

* Virtual Drive // Include a "public" folder controlled from api.
* Front End // UI with React.


## Install API (Virtual Drive)
Use an hosting only to upload the "virtualdrive" folder.

##### The "virtualdrive" folder include:
- api // This folder include the API files for access to public folder (with this api you can navigate, delete, rename and create files or folder into public folder).
- public // Is the public folder to navigate.



## Install Front End (UI)
Is a React project to use the API.


##### Make a Git Clone
```
$ git clone git@github.com:claudiogaraycochea/browsercommander.git
```

##### Install the dependencies
```
$ yarn
```

##### Run Project
```
$ cd browsercommander
$ yarn start
```


## Ready!!!
Open the URL http://localchost:3000 


## Support
Claudio Garaycochea : computadoraweb@gmail.com
