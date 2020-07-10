# Luxury Services
## todo
- [ ] Import simplon-tp-product-hunt with doctrine
    + [ ] Study how doctrine deals with the different relationship 
          cardinality types
- [ ] Let symfony's auth bundle thing deal with user and piggyback profile off 
      it
- [ ] Be very careful with the ON DELETE/UPDATE cascade clause
    + [ ] Check if/how Doctrine specify them
- [ ] Consider alternative ways to handle the polymorphic association necessary
      for adminNote

## notes
```
user
    id
    email
    passwordHash?
    role
    createdAt
    updatedAt

profile
    id
    ->user
    ->jobSector
    ->adminNotes
    firstName
    lastName
    gender
    address
    country
    nationality
    hasPassport
    passportScan
    curriculumVitae
    picture
    currentLocation
    dateOfBirth
    placeOfBirth
    isAvailable
    experience
    description
    createdAt
    updatedAt
    deletedAt

adminNote
    id
    content
    files
    createdAt
    updatedAt

\\adminNoteTarget
\\    id
\\    type

application
    ->profile
    ->job
    createdAt

client
    id

    ->adminNote
    ->jobSector

    companyName
    contactName
    contactPosition
    email
    phone
    createdAt
    updatedAt

job
    id
    ->client
    ->adminNote
    ->jobSector


jobSector
    id
    name
```