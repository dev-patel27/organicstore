'use strict';

var x, i, j, selElmnt, a, b, c;
for (x = document.getElementsByClassName("custom-select2"), i = 0; i < x.length; i++) {
    for (selElmnt = x[i].getElementsByTagName("select")[0], (a = document.createElement("DIV")).setAttribute("class", "select-selected2"), a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML, x[i].appendChild(a), (b = document.createElement("DIV")).setAttribute("class", "select-items2 select-hide2"), j = 1; j < selElmnt.length; j++) (c = document.createElement("DIV")).innerHTML = selElmnt.options[j].innerHTML, c.addEventListener("click", function (e) {
        var t, s, l, n, i;
        for (n = this.parentNode.parentNode.getElementsByTagName("select")[0], i = this.parentNode.previousSibling, s = 0; s < n.length; s++) if (n.options[s].innerHTML == this.innerHTML) {
            for (n.selectedIndex = s, i.innerHTML = this.innerHTML, t = this.parentNode.getElementsByClassName("same-as-selected2"), l = 0; l < t.length; l++) t[l].removeAttribute("class");
            this.setAttribute("class", "same-as-selected2");
            break
        }
        i.on("click")
    }), b.appendChild(c);
    x[i].appendChild(b), a.addEventListener("click", function (e) {
        e.stopPropagation(), closeAllSelect(this), this.nextSibling.classList.toggle("select-hide2"), this.classList.toggle("select-arrow-active")
    })
}

function closeAllSelect(e) {
    var t, s, l, n = [];
    for (t = document.getElementsByClassName("select-items2"), s = document.getElementsByClassName("select-selected2"), l = 0; l < s.length; l++) e == s[l] ? n.push(l) : s[l].classList.remove("select-arrow-active");
    for (l = 0; l < t.length; l++) n.indexOf(l) && t[l].classList.add("select-hide2")
}

document.addEventListener("click", closeAllSelect);




