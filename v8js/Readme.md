This folder holds the configs & dependencies required to render a React component on the server.

Steps:
* run `yarn run build:dll` to transpile the shared libraries
* run `yarn run build:src` to transpile the components

Note: When you first run a page that uses a snapshot, it will be built in /v8/snapshot.bin upon first access (then reused forever after).

Then you can go and visit:
* https://dev.vanilla.localhost/test
* https://dev.vanilla.localhost/test/v8js
* https://dev.vanilla.localhost/test/react
* https://dev.vanilla.localhost/test/snapshot
* https://dev.vanilla.localhost/test/props
