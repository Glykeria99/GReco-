var dialog = document.getElementById("delete-topic-dialog");

function openDeleteTopicDialog(topicID)
{
  dialog.style.display = "block";
  var inputTopicID = document.getElementById("input-topicID");
  inputTopicID.value = topicID;
}

function closeDialog()
{
    dialog.style.display = "none";
}