<form action="/add" method="post" enctype="multipart/form-data">
  <dl>
    <dt><label for="bookTitle">Enter book title</label></dt>
    <dd>
      <input type="text" name="bookTitle" id = "bookTitle" required
      placeholder = "Enter book title [Only string]">
    </dd>

    <dt><label for="bookImage">Upload book image</label></dt>
    <dd>
      <input type="file" name="bookImage" id = "bookImage" required
      placeholder = "Upload book image [Only Image type]">
    </dd>

    <dt><label for="bookDesc">Enter book description</label></dt>
    <dd>
      <input type="text" name="bookDesc" id = "bookDesc" required
      placeholder = "Enter a short book description">
    </dd>

    <dt><label for="bookCost">Enter book cost</label></dt>
    <dd>
      <input type="text" name="bookCost" id = "bookCost" required
      placeholder = "Enter book cost [Only number]">
    </dd>

    <dt><label for="bookAuthor">Enter book Author name</label></dt>
    <dd>
      <input type="text" name="bookAuthor" id = "bookAuthor" required
      placeholder = "Enter book Author name">
    </dd>

    <dd>
      <button name="addBtn" id="submitBtn">Add boook</button>
    </dd>
  </dl>
</form>
