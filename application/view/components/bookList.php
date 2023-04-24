<div class = "">
  <ul class = "d-flex justify-content-around pt-2 pb-2 border border-5">
    <li>Book Title</li>
    <li>Book Image</li>
    <li>Book Desc</li>
    <li>Book Cost</li>
    <li>Book Author</li>
  </ul>
  <?php if(isset($_SESSION['bookList'])) { ?>
    <?php foreach($_SESSION['bookList'] as $rowWise) { ?>
      <div>
        <ul class = "d-flex justify-content-around">
          <li>
            <?php echo $rowWise['bookTitle']; ?>
          </li>
          <li>
            <img src="<?php echo $rowWise['bookImage']; ?>" alt="">
          </li>
          <li>
            <?php echo $rowWise['bookDesc']; ?>
          </li>
          <li>
            Rs.<?php echo $rowWise['bookCost']; ?>/-
          </li>
          <li>
            Mr./Mrs.<?php echo $rowWise['bookAuthor']; ?>
          </li>
        </ul>
      </div>
    <?php } ?>
  <?php } ?>
</div>
