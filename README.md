# CarTrack Interview Test [Kalai]

REST Api project without framework dependencies.

## Usage

I've used `cars` table from provided details.

### Routes as follow

METHOD  | Route | Content Body | Description
------------- | -------------| -------------| -------------
GET     | `cartrack.staging-host.dev`| -| - to list all record
GET     | `cartrack.staging-host.dev/{id}`| -| - to list record by id
POST    | `cartrack.staging-host.dev`| {"name": "Hilux","type": "Sedan","brand": "Toyota","year": "2020"}| - to create new record
PUT     | `cartrack.staging-host.dev/{id}`| {"name": "Hilux","type": "Sedan","brand": "Toyota","year": "2020"}| - to update old record with given id
DELETE  | `cartrack.staging-host.dev/{id}`| -| - to delete record by id

### Validation

- [x] Accessing `GET` Method with invalid `id`
- [x] Accessing `PUT` Method with invalid `id`
- [x] Accessing `DELETE` Method with invalid `id`
- [x] Accessing `POST` Method with invalid post data
- [x] Accessing `PUT` Method with invalid post data

