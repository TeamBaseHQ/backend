Base (Backend)
====

Backend for the Base app.

## Schema
---------
## Entities

### Application
- ID
- Key
- Name
- Secret
- Picture 
- Description

### User
- ID 
- Name
- Email
- Picture
- Password
- Is Verified

### Team
- ID
- Name
- Slug
- Picture
- Description
- Creator (User)
- Invitation Code

### TeamMember 
- ID
- User
- Team

### Channel
- ID 
- Slug
- Name
- Team
- Color
- Description
- User (Creator)
- NotificationMeta
- Type (Private | Public | Direct)

### ChannelMember 
- ID
- User
- Channel
- Last Viewed At
- Messages Viewed

### Thread
- ID
- Slug
- Channel
- Subject
- Description
- NotificationMeta 

### Message
- ID
- Slug 
- Type
- Meta
- Thread
- Content
- Sender (User | Application)

### File
- ID
- User
- Team
- Type
- Meta

### Attachment
- ID
- File
- Message

### Star
- ID
- User
- Message 

### Invitation
- ID
- Team
- Email
- Message
- Is Accepted

### Integration
- ID 
- Channel  
- Application

### Preference Category
- ID
- Name

### Preference
- ID
- Name
- Data Type
- Default Value
- Preference Category

### Custom Preference
- ID
- Value
- Owner
- Preference

## Relationships

#### User Teams
- A User belongs to many Team
- A Team belongs to many User

#### User Created Teams
- A User (creator) has many Team
- A Team belongs to a User (creator)

### Team Members
- A Team belongs to many User
- A User belongs to many Team

#### Team Channels
- A Team has many Channel
- A Channel belongs to a Team

#### Channel Threads
- A Channel has many Threads
- A Thread belongs to a Channel

### Channel Members
- A Channel belongs to many User
- A User belongs to many Channel

#### Thread Messages
- A Thread has many Message
- A Message belongs to a Thread

#### Team Files 
- A Team has many File
- A File belongs to a Team

#### User Files 
- A User has many File
- A File belongs to a User

#### Message Attachments
- A Message has many Attachment
- A Attachment belongs to a Message

#### Starred Messages
- A Message belongs to many User
- A User belongs to many Message

#### Thread Subscriptions
- A User belongs to many Thread
- A Thread belongs to many User

#### Channel Integrations
- A Channel belongs to many Integration
- A Integration belongs to many Channel

#### Thread Integrations
- A Thread belongs to many Integration
- A Integration belongs to many Thread

#### Application Integrations
- A Application has many Integrations
- A Integration belongs to a Application

#### PreferenceCategory Preferences
- A PreferenceCategory has many Preferences
- A Preference belongs to a PreferenceCategory

#### User Preferences
- A User belongs to many Preferences
- A Preference belongs to many User

#### Team Invitations
- A Team has many Invitation
- A Invitation belongs to a Team


## Endpoints
-------------------

#### User
- Create: `POST /users`
- Log in: `POST /users/auth`
- Show: `GET /users/{id}`
- Update: `PATCH /users/{id}`

#### Team
- Create: `POST /teams`
- List: `GET /teams`
- Show: `GET /teams/{id}`
- Update: `PATCH /teams/{id}`
- Delete: `DELETE /teams/{id}`
- Members
    - List: `GET /teams/{id}/members`
    - Add: `POST /teams/{id}/members`
    - Show: `GET /teams/{id}/members/{uid}`
    - Remove: `DELETE /teams/{id}/members/{uid}`

#### Channel
- Create: `POST /teams/{id}/channels`
- List: `GET /teams/{id}/channels`
- Show: `GET /teams/{id}/channels/{cid}`
- Update: `PATCH /teams/{id}/channels/{cid}`
- Delete: `DELETE /teams/{id}/channels/{cid}`
- Members
    - List: `GET /teams/{id}/channels/{cid}/members`
    - Add: `POST /teams/{id}/channels/{cid}/members`
    - Remove: `DELETE /teams/{id}/channels/{cid}/members/{uid}`

#### Thread
- Create: `POST /teams/{id}/channels/{cid}/threads`
- List: `GET /teams/{id}/channels/{cid}/threads`
- Show: `GET /teams/{id}/channels/{cid}/threads/{tid}`
- Update: `PATCH /teams/{id}/channels/{cid}/threads/{tid}`
- Delete: `DELETE /teams/{id}/channels/{cid}/threads/{tid}`

#### Message
- Create: `POST /teams/{id}/channels/{cid}/threads/{tid}/messages`
- List: `GET /teams/{id}/channels/{cid}/threads/{tid}/messages`
- Show: `GET /teams/{id}/channels/{cid}/threads/{tid}/messages/{mid}`
- Update: `PATCH /teams/{id}/channels/{cid}/threads/{tid}/messages/{mid}`
- Delete: `DELETE /teams/{id}/channels/{cid}/threads/{tid}/messages/{mid}`
- Star
    - Create: `POST /teams/{id}/channels/{cid}/threads/{tid}/messages/{mid}/star`
    - Delete: `DELETE /teams/{id}/channels/{cid}/threads/{tid}/messages/{mid}/star`

#### PreferenceCategory
- List: `GET /preference-categories`
- Show: `GET /preference-categories/{id}`

#### Preference
- List: `GET /preferences`
- Show: `GET /preferences/{id}`

#### CustomPreferences
- List: `GET /teams/{id}/users/{uid}/preferences`
- Add: `POST /teams/{id}/users/{uid}/preferences`
- Show: `GET /teams/{id}/users/{uid}/preferences/{pid}`
- Remove: `DELETE /teams/{id}/users/{uid}/preferences/{pid}`
