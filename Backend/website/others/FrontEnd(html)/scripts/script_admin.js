// Simulare de listă de admini
const adminList = [
    { id: 1, username: "admin1" },
    { id: 2, username: "admin2" },
    { id: 3, username: "admin3" }
];

// Funcție pentru afișarea listei de admini
function displayAdminList() {
    const adminListContainer = document.getElementById("admin-list");
    adminListContainer.innerHTML = ""; // Curăță containerul

    adminList.forEach(admin => {
        const adminItem = document.createElement("div");
        adminItem.textContent = `ID: ${admin.id}, Username: ${admin.username}`;
        adminListContainer.appendChild(adminItem);
    });
}

// Funcție pentru adăugarea unui admin
function addAdmin() {
    const newAdmin = { id: adminList.length + 1, username: "newadmin" };
    adminList.push(newAdmin);
    displayAdminList();
}

// Adaugă event listener pentru butonul "Add Admin"
document.getElementById("add-admin").addEventListener("click", addAdmin);

// Afisează lista de admini la încărcarea paginii
displayAdminList();
