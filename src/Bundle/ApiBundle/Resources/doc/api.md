# Number management #

### `GET` /users/{id}/numbers ###

_Gets user phone number objects_

Gets user phone number objects

#### Requirements ####

**id**

  - Requirement: \d+

#### Response ####

[]:

  * type: array of objects (PhoneNumber)

[][number]:

  * type: integer

[][id]:

  * type: integer


### `POST` /users/{id}/numbers ###

_Creates phone number object_

Creates phone number object

#### Requirements ####

**id**

  - Requirement: \d+

#### Parameters ####

number:

  * type: integer
  * required: true

#### Response ####

number:

  * type: integer

id:

  * type: integer


### `GET` /users/{id}/numbers/{numberId} ###

_Gets user phone number object_

Gets user phone number object

#### Requirements ####

**id**

  - Requirement: \d+
**numberId**

  - Requirement: \d+

#### Response ####

number:

  * type: integer

id:

  * type: integer


### `PUT` /users/{id}/numbers/{numberId} ###

_Edits phone number object_

Edits phone number object

#### Requirements ####

**id**

  - Requirement: \d+
**numberId**

  - Requirement: \d+

#### Parameters ####

number:

  * type: integer
  * required: true

#### Response ####

number:

  * type: integer

id:

  * type: integer


### `DELETE` /users/{id}/numbers/{numberId} ###

_Removes phone number object_

Removes phone number object

#### Requirements ####

**id**

  - Requirement: \d+
**numberId**

  - Requirement: \d+



# User management #

### `GET` /users ###

_Fetches list of users_

Fetches list of users

#### Parameters ####

firstName:

  * type: string
  * required: false
  * description: First name to search for

lastName:

  * type: string
  * required: false
  * description: Last name to search for

nickname:

  * type: string
  * required: false
  * description: Nickname to search for

#### Response ####

[]:

  * type: array of objects (User)

[][firstName]:

  * type: string

[][lastName]:

  * type: string

[][nickname]:

  * type: string

[][id]:

  * type: integer


### `POST` /users ###

_Create user object_

#### Parameters ####

firstName:

  * type: string
  * required: true

lastName:

  * type: string
  * required: true

nickname:

  * type: string
  * required: true

#### Response ####

firstName:

  * type: string

lastName:

  * type: string

nickname:

  * type: string

id:

  * type: integer


### `GET` /users/{id} ###

_Gets user object_

Gets user object

#### Requirements ####

**id**

  - Requirement: \d+
  - Type: int

#### Response ####

firstName:

  * type: string

lastName:

  * type: string

nickname:

  * type: string

id:

  * type: integer


### `PUT` /users/{id} ###

_Edits user object_

Edits user object

#### Requirements ####

**id**

  - Requirement: \d+

#### Parameters ####

firstName:

  * type: string
  * required: true

lastName:

  * type: string
  * required: true

nickname:

  * type: string
  * required: true

#### Response ####

firstName:

  * type: string

lastName:

  * type: string

nickname:

  * type: string

id:

  * type: integer


### `DELETE` /users/{id} ###

_Removes user object_

Removes user object

#### Requirements ####

**id**

  - Requirement: \d+
