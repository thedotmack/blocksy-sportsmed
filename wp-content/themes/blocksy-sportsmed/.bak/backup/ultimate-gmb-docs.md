# Documentation

## Overview

The provided PHP code is for integrating and using the Google Places API with WordPress. The Google Places API is a service that returns information about a particular place using HTTP requests. The code provides functionalities to fetch and display the details, reviews, photos and other relevant data of a specific place using its `placeId`. This `placeId` is a unique identifier for a place in the Google Places database.

---

## Defined Constants

- `GOOGLE_API_KEY`: API key for the Google API. It is defined as a constant for use throughout the classes.

---

## Classes

### `GooglePlaceAPI`

This is the base class that is used to construct the URL for the API request and make the request to the Google Places API.

#### Methods

- `__construct($placeId)`: Constructor. Accepts a place id and sets it as an instance variable.
- `makeApiRequest($fields)`: Makes a GET request to the Google Places API and retrieves the place details.

### `GooglePlaceReviews`

This is a subclass of `GooglePlaceAPI` that fetches and displays the reviews for a place.

#### Methods

- `getReviews()`: Fetches the reviews from the API and formats them in a carousel view.

### `GooglePlaceReviewsContent`

This is another subclass of `GooglePlaceAPI` that fetches the content of the reviews for a place.

#### Methods

- `getReviewContent($numberOfReviews)`: Fetches a specified number of reviews from the API and formats the output.

### `GooglePlacePhotos`

This is a subclass of `GooglePlaceAPI` that fetches the photos for a place.

#### Methods

- `__construct($placeId, $postId)`: Constructor. Accepts a place id and a post id. Calls the parent constructor with the place id and sets the post id as an instance variable.
- `getPhotos()`: Fetches the photos from the API and updates the WordPress post meta with the returned photo URLs.

### `GooglePlaceDetails`

This is a subclass of `GooglePlaceAPI` that fetches and updates the place details.

#### Methods

- `__construct($placeId, $postId)`: Constructor. Accepts a place id and a post id. Calls the parent constructor with the place id and sets the post id as an instance variable.
- `updatePlaceDetails()`: Fetches the place details from the API and updates the WordPress post meta with the returned data.

---

## Hooks and Functions

The code contains various WordPress hooks and helper functions:

- `add_location_photos_meta_box()`: This function is hooked into `add_meta_boxes`, and adds a meta box to the WordPress post editing screen for displaying and selecting the primary photo from the fetched Google Place photos.
- `location_photos_meta_box_cb($post)`: This is the callback function for rendering the location photos meta box. It also fetches the photos if they are not already stored in the post meta.
- `save_primary_photo($post_id)`: This function is hooked into `save_post`, and it saves the selected primary photo URL as post meta when the post is saved.
- `get_primary_photo_url($post_id)`: This function returns the stored primary photo URL for a post.
- `getOpeningHours($placeDetails)`: This helper function parses the opening hours data from the fetched place details.
- `display_opening_hours()`: This function displays the opening hours in a formatted table.
- `get_address()`: This function fetches and returns the formatted address from the fetched place details.
