document.addEventListener("DOMContentLoaded", () => {
    const editButton = document.getElementById("edit-button");
    const saveButton = document.getElementById("save-button");

    const profileDisplay = document.querySelector(".profile-display");
    const profileEdit = document.querySelector(".profile-edit");

    const profilePicture = document.getElementById("profile-picture");
    const firstnameSpan = document.querySelector("#firstname span");
    const lastnameSpan = document.querySelector("#lastname span");
    const emailSpan = document.querySelector("#email span");

    const editPictureInput = document.getElementById("edit-picture");
    const editFirstnameInput = document.getElementById("edit-firstname");
    const editLastnameInput = document.getElementById("edit-lastname");
    const editEmailInput = document.getElementById("edit-email");

    editButton.addEventListener("click", () => {
        profileDisplay.classList.add("hidden");
        profileEdit.classList.remove("hidden");
    });

    saveButton.addEventListener("click", () => {
        if (editPictureInput.files && editPictureInput.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                profilePicture.src = e.target.result;
            };
            reader.readAsDataURL(editPictureInput.files[0]);
        }

        firstnameSpan.textContent = editFirstnameInput.value;
        lastnameSpan.textContent = editLastnameInput.value;
        emailSpan.textContent = editEmailInput.value;

        profileEdit.classList.add("hidden");
        profileDisplay.classList.remove("hidden");
    });
});
