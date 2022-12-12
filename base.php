<style>

    

   
    /* Items keep disappearing when resizing --> has to do with navbar-fixed-top but not sure how to fix, since removing results in error */
    .topnav {
  background-color: #333;
  overflow: hidden;
}

/* Style the links inside the navigation bar */
.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

/* Change the color of links on hover */
.topnav a:hover {
  background-color: #ddd;
  color: black;
}

/* Add a color to the active/current link */
.topnav a.active {
  background-color: #d62929;
  color: white;
}

  </style>

<body>
<div class="topnav">
  <a id="homepage" href="homepage.php">Homepage</a>
  <a id="form" href="createPostForm.php">Create Post</a>
  <a id="profile" href="profile.php">Profile</a>
</div>
<body>  