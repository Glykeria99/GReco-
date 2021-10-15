// Get the modal
var modal = document.getElementById("reply-modal");
var quote = document.getElementById("modalQuote");

/*var modalQuote = document.getElementById("modalQuote").innerHTML;
var inputQuote = document.getElementById("inputQuote");
var submitModalReplyBtn = document.getElementById("submitModalReply");

submitModalReplyBtn.onClick(function(){
  inputQuote.val(modalQuote);
});*/

// When the user clicks the button, open the modal 
function openModal(textID)
{
  modal.style.display = "block";
  quote.innerHTML = "Ανάρτηση από τον <b>" + document.getElementById("postUser"+textID).innerHTML + "</b>:<br><br>" + document.getElementById(textID).innerHTML;
  var inputQuote = document.getElementById("inputQuote");
  inputQuote.value = quote.innerHTML;
}

// When the user clicks on <span> (x), close the modal
function closeModal()
{
  modal.style.display = "none";
}

function redirectToLogin()
{
  location.href="login.php";
}


//Section for the delete post dialog
var deleteDialog = document.getElementById("delete-post-dialog");

function openDeletePostDialog(postID)
{
  deleteDialog.style.display = "block";
  var deleteInputPostID = document.getElementById("delete-input-postID");
  deleteInputPostID.value = postID;
}

function closeDeleteDialog()
{
    deleteDialog.style.display = "none";
}


//Section for edit post dialog
var editPostDialog = document.getElementById("edit-post-dialog");
var editPostText = document.getElementById("edit-post-text");

function openEditPostDialog(postID)
{
  editPostDialog.style.display = "block";
  editPostText.value = document.getElementById(postID).innerHTML;
  var editInputPostID = document.getElementById("edit-input-postID");
  editInputPostID.value = postID;
}

function closeEditPostDialog()
{
    editPostDialog.style.display = "none";
}

//Section for edit topic dialog
var editTopicDialog = document.getElementById("edit-topic-dialog");
var editTopicText = document.getElementById("edit-topic-text");

function openEditTopicDialog(topicID)
{
  editTopicDialog.style.display = "block";
  editTopicText.value = document.getElementById(0).innerHTML;
  var editInputTopicID = document.getElementById("edit-input-topicID");
  editInputTopicID.value = topicID;
}

function closeEditTopicDialog()
{
  editTopicDialog.style.display = "none";
}