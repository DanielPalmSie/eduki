
# Project Setup and Usage Guide

Welcome to our project! This guide will walk you through the steps to get the project up and running on your local machine and how to use its features effectively.

## Getting Started

### Launching the Project

1. **Start the Project:**

   To launch the project, you will need to execute the `start.sh` script. This script is responsible for building and starting the project, making it accessible on your local machine. Run the following command in your terminal:

   ```bash
   sh start.sh
   ```

   Ensure that `start.sh` script is executable. If not, make it executable by running:

   ```bash
   chmod +x start.sh
   ```

   After launching, the project will be accessible at [http://application.local/](http://application.local/).

## Using the Application

Our application offers a simple yet powerful URL shortening service. Below are examples of how to interact with the application's endpoints.

### 1. Shortening a URL

To shorten a URL, you need to send a POST request to the `/shorten` endpoint, including the URL you wish to shorten in the request body. Here's how you can do it using `curl`:

```bash
curl -X POST http://application.local/shorten -d 'url=https://www.example.com'
```

This request will return a JSON object containing both the original URL and the newly created shortened URL.

### 2. Using a Shortened URL

To navigate using a shortened URL, access the following path, replacing `{shortCode}` with the code returned by the `/shorten` endpoint:

```plaintext
http://application.local/r/{shortCode}
```

This action will redirect you to the original URL associated with the provided short code.

---

Thank you for using our application! If you have any questions or need further assistance, please feel free to reach out.
