const upgradeButtons = document.querySelectorAll(".upgrade");
const downgradeButtons = document.querySelectorAll(".downgrade");
const deleteButtons = document.querySelectorAll(".delete");

function upgradeRole(){
    const container = this.parentElement;
    const id = container.getAttribute("id");

    fetch(`/upgrade/${id}`)
        .then(function (){
            window.location.reload();

        });
}
function downgradeRole(){
    const container = this.parentElement;
    const id = container.getAttribute("id");

    fetch(`/downgrade/${id}`)
        .then(function (){
            window.location.reload();
        });

}
function deleteUser(){
    const container = this.parentElement;
    const id = container.getAttribute("id");

    const roleType = this.previousElementSibling.previousElementSibling.previousElementSibling.innerHTML;
    console.log(id);
    if(roleType === 'Administrator'){
        window.alert("Nie można usunąć Administratora");
        return;
    }
    fetch(`/delete_user/${id}`)
        .then(function (){
            window.location.reload();
        });
}
deleteButtons.forEach(button => button.addEventListener("click", deleteUser));
upgradeButtons.forEach(button => button.addEventListener("click", upgradeRole));
downgradeButtons.forEach(button => button.addEventListener("click", downgradeRole));

