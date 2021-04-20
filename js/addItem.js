 // send addItem into to the php file
 let addItem = (event) => {
    event.preventDefault();
    var itemType = $("#ghost_itemType").val();
    var itemText = $("#add_projectItem").val();
    var projectID = $("#ghost_ProjectID").val();
    var projectsCount = $("#ghost_projectsCount").val();
    var submit = $("#send_addProjectItem").val();
    $("#addItem_data").load("includes/addProjectItem.inc.php", {
      itemType: itemType,
      itemText: itemText,
      projectID: projectID,
      projectsCount: projectsCount,
      submit: submit
    });
}

let removeItem = (parent_index) => {
  var itemID = parent_index;
  var projectsCount = $("#ghost_projectsCount").val();
  $("#addItem_data").load("includes/removeProjectItem.inc.php", {
    itemID: itemID,
    projectsCount: projectsCount
  });
}

let addAvatar = () => {
  var username = $('#username').val();
  var avatarName = $('#ghost_avatarName').val();
  var avatarSet = $('#ghost_submit').val();
  $('#signup-data').load('includes/signup.inc.php', {
      username: username,
      avatarName: avatarName,
      avatarSet: avatarSet
  });
}

let editOption = () => {
  var optionValue = $('#ghost_optionValue').val();
  var optionName = $('#ghost_optionName').val();
  var projectID = $("#ghost_ProjectID").val();
  var projectsCount = $("#ghost_projectsCount").val();
  $('#edit-option-data').load('includes/editProjectOption.inc.php', {
    optionValue: optionValue,
    optionName: optionName,
    projectID: projectID,
    projectsCount: projectsCount
});
}