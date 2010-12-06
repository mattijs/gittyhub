# Gittyhub

Gittyhub is a PHP 5.3 client for interacting with the Github API. It originated 
out of a need to have a library that integrates with PHP 5.3 based projects, 
mainly [lithium](http://lithify.me) based projects.

For a complete Github API desciption see [develop.github.com](http://develop.github.com).

## Status

Not all API sections are implemented. The client leans on lithium for http 
requests and responses but the plan is to make this a standalone library to 
easily integrate it with non lithium based projects.

Caching is not yet implemented so be gentile with the amount of request made to 
the API. The Github API is limited to 60 requests an hour per user. After this 
_"access denied"_ errors will occur.

# License

Gittyhub is licensed under the MIT License. See the LICENSE file for more 
details.

Lithium is Copyright (c) 2010, [Union of RAD](http://union-of-rad.org) and 
licensed under the MIT license. See lib/lithium/LICENSE.txt for full details.
