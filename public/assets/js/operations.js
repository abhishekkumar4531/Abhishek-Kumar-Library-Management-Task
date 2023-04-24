$( document ).ready(function() {
  $("#addButton").on('click', function(e) {
    e.preventDefault;
    var new_item = $("#new_item").val();
    if(new_item != "") {
      $.ajax({
        type: "POST",
        url: "/home/addList",
        data: {newItem : new_item},
        success: function(data) {
          if(data) {
            displayListData();
          }
          else {
            alert("Check error during insertion!!!");
          }
        }
      });
    }
    else {
      alert("Please fill the list feild!!!");
    }
  });

  $(document).on('click','.editBtn',function(e){
    var item_id = $(this).data("id");
    var item_value = $(this).data("value");
    var edit_value = prompt("Edit your value :", item_value);

    $.ajax({
      type: "POST",
      url: "/home/edit",
      data: {itemId : item_id, editValue : edit_value},

      success: function(data) {
        if(data) {
          displayListData();
        }
        else {
          alert("Check error while editing");
        }
      }
    });
  });

  $(document).on('click','.deleteBtn',function(e){
    var item_id = $(this).data("id");
    deleteData(item_id);
  });

  $(document).on('click','.deleteMarkedBtn',function(e){
    var item_id = $(this).data("id");
    deleteMarkedData(item_id);
  });

  $(document).on('click','.markedBtn',function(e){
    var item_id = $(this).data("id");
    var item_value = $(this).data("value");
    $.ajax({
      type: "POST",
      url: "/home/markDone",
      data: {itemValue : item_value},

      success: function(data) {
        if(data) {
          deleteData(item_id);
          displayMarkedData();
        }
        else {
          alert("Check error after deletion!!!");
        }
      }
    });
  });

  function deleteData(item_id) {
    // var item_id = $(this).data("id");
    $.ajax({
      type: "POST",
      url: "/home/delete",
      data: {itemId : item_id},

      success: function(data) {
        if(data) {
          displayListData();
        }
        else {
          alert("Check error after deletion!!!");
        }
      }
    });
  }

  function deleteMarkedData(item_id) {
    $.ajax({
      type: "POST",
      url: "/home/deleteMarked",
      data: {itemId : item_id},

      success: function(data) {
        if(data) {
          displayMarkedData();
        }
        else {
          alert("Check error after deletion!!!");
        }
      }
    });
  }

  function displayListData() {
    $.ajax({
      type: "POST",
      url: "/home/getListData",

      success: function(data) {
        $("#display-data").html(data);
      }
    });
  }

  function displayMarkedData() {
    $.ajax({
      type: "POST",
      url: "/home/getMarkedData",

      success: function(data) {
        $("#display-marked-data").html(data);
      }
    });
  }

  displayListData();
  displayMarkedData();
});
