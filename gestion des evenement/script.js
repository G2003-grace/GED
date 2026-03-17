/* script.js */ document.addEventListener("DOMContentLoaded",
     () => { const box = document.getElementById("box"); const status = document.getElementById("status");

    box.addEventListener("mouseover", () => {
        status.textContent = "La souris est sur la boîte!";
    });
    
    box.addEventListener("mouseout", () => {
        status.textContent = "Souris partie.";
    });
    
    document.getElementById("box").addEventListener("click", function() {
        this.style.backgroundColor = "red";
        });
       
    
     document.getElementById("box").addEventListener("dblclick", function() {
        this.style.backgroundColor = "blue";
            });

    
    
    });

 