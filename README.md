# Packt Interview ( Server )

The client has requested that there be a search page and a product page as a bare
minimum with the idea that a user will input a title of a book and be given a list of
available products.

## Deployment

* to Install dependency libraries run command from the project directory
```bash
  composer install
```

* Create Database and update name on **.env** file 
```bash
  DB_DATABASE=packt_assignment
  DB_USERNAME=root
  DB_PASSWORD=*****
```

* Generate symbolic link for storage folder

```bash
  php artisan storage:link
```

To deploy this project run

```bash
  php artisan serve
```


## API Reference

#### Get books collections

```http
  GET /api/book-collections
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `q` | `string` | **Nullable**. Search Parameter |
| `page` | `number` | **Nullable**.Pagination number |
| `author_id` | `uuid` | **Nullable**. Author ID should be exists in authors |
| `publisher_id` | `uuid` | **Nullable**. Publisher ID should be exists in publishers |
| `genre_id` | `uuid` | **Nullable**. Genre ID shoule be exists in genres |

#### Get all books

```http
  GET /api/book
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `q` | `string` | Search Parameter |
| `page` | `number` | Pagination number |

#### Get single book

```http
  GET /api/book/${id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Required**. Id of item to fetch |


#### Create book

```http
  POST /api/book
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `title`      | `string` | **Required**. |
| `genre_id`   | `string` | **Required**. Should be exists in genres |
| `author_id`   | `string` | **Required**. Should be exists in authors |
| `publisher_id`   | `string` | **Required**. Should be exists in publishers |
| `publisher_at`   | `date` | **Required**. Published Date |
| `isbn`   | `numeric` | **Required, Unique**. Unique number to identify |
| `description`   | `string` | **Nullable**. |
| `gallery_id`   | `string` | **Required**. Uploaded image uuid | 


#### Update book

```http
  PUT /api/book/${id}
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `title`      | `string` | **Required**. |
| `genre_id`   | `string` | **Required**. Should be exists in genres |
| `author_id`   | `string` | **Required**. Should be exists in authors |
| `publisher_id`   | `string` | **Required**. Should be exists in publishers |
| `publisher_at`   | `date` | **Required**. Published Date |
| `isbn`   | `numeric` | **Required, Unique**. Unique number to identify |
| `description`   | `string` | **Nullable**. |
| `gallery_id`   | `string` | **Required**. | Uploaded image uuid

#### Delete book

```http
  DELETE /api/book/${id}
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Required**. Id of item to delete |

------------
------------

#### Get all author

```http
  GET /api/author
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `q` | `string` | Search Parameter |
| `page` | `number` | Pagination number |

#### Get single author

```http
  GET /api/author/${id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Required**. Id of item to fetch |


#### Create Author

```http
  POST /api/author
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `author_name`      | `string` | **Required, Unique**. Author name to choose for book|
| `email`   | `string` | **Required, Unique**. |
| `phone_number`   | `string` | **Required, Unique**. |
| `address`   | `string` | **Nullable**. |


#### Update author

```http
  PUT /api/author/${id}
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `author_name`      | `string` | **Required, Unique**. Author name to choose for book|
| `email`   | `string` | **Required, Unique**. |
| `phone_number`   | `string` | **Required, Unique**. |
| `address`   | `string` | **Nullable**. |

#### Delete author

```http
  DELETE /api/author/${id}
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Required**. Id of item to delete |


------------
------------

#### Get all publisher

```http
  GET /api/publisher
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `q` | `string` | Search Parameter |
| `page` | `number` | Pagination number |

#### Get single author

```http
  GET /api/publisher/${id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Required**. Id of item to fetch |


#### Create publisher

```http
  POST /api/publisher
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `publisher_name`      | `string` | **Required, Unique**. Author name to choose for book|
| `email`   | `string` | **Required, Unique**. |
| `phone_number`   | `string` | **Required, Unique**. |
| `address`   | `string` | **Nullable**. |


#### Update publisher

```http
  PUT /api/publisher/${id}
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `publisher_name`      | `string` | **Required, Unique**. Author name to choose for book|
| `email`   | `string` | **Required, Unique**. |
| `phone_number`   | `string` | **Required, Unique**. |
| `address`   | `string` | **Nullable**. |

#### Delete publisher

```http
  DELETE /api/publisher/${id}
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Required**. Id of item to delete |


------------
------------

#### Get all genre

```http
  GET /api/genre
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `q` | `string` | Search Parameter |
| `page` | `number` | Pagination number |

#### Get single genre

```http
  GET /api/genre/${id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Required**. Id of item to fetch |


#### Create genre

```http
  POST /api/genre
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `genre_name`      | `string` | **Required, Unique**. Author name to choose for book|
| `description`   | `string` | **Nullable**. |


#### Update genre

```http
  PUT /api/genre/${id}
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `genre_name`      | `string` | **Required, Unique**. Author name to choose for book|
| `description`   | `string` | **Nullable**. |

#### Delete genre

```http
  DELETE /api/genre/${id}
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Required**. Id of item to delete |

