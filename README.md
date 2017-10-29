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
- Picture
- Description
- Creator (User)
- Invitation Code

### Channel
- ID 
- Name
- Team
- Color
- Description
- User (Creator)
- Type (Private | Public | Direct)

### Thread
- ID 
- Subject
- Channel
- Description

### Message
- ID 
- Content
- Channel
- Sender (User)

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

### ChannelMember 
- ID
- User
- Channel
- Last Viewed At
- Messages Viewed

### Star
- ID
- User
- Message 

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

### User Preference
- ID
- User
- Value
- Preference

### Invitation
- ID
- Team
- Email
- Is Accepted

## Relationships

#### User Teams
- A User belongs to many Team
- A Team belongs to many User

#### User Created Teams
- A User (creator) has many Team
- A Team belongs to a User (creator)

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
