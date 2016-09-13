(function (c) {
    function e(w) {
        var v = {};
        if (w.selectionStart === undefined) {
            w.focus();
            var u = document.selection.createRange();
            v.length = u.text.length;
            u.moveStart("character", -w.value.length);
            v.end = u.text.length;
            v.start = v.end - v.length
        } else {
            v.start = w.selectionStart;
            v.end = w.selectionEnd;
            v.length = v.end - v.start
        }
        return v
    }

    function t(w, x, u) {
        if (w.selectionStart === undefined) {
            w.focus();
            var v = w.createTextRange();
            v.collapse(true);
            v.moveEnd("character", u);
            v.moveStart("character", x);
            v.select()
        } else {
            w.selectionStart = x;
            w.selectionEnd = u
        }
    }

    function j(v, u) {
        c.each(u, function (w, x) {
            if (typeof x === "function") {
                u[w] = x(v, u, w)
            } else {
                if (typeof v.autoNumeric[x] === "function") {
                    u[w] = v.autoNumeric[x](v, u, w)
                }
            }
        })
    }

    function b(v, u) {
        if (typeof(v[u]) === "string") {
            v[u] *= 1
        }
    }

    function s(y, x) {
        j(y, x);
        x.oEvent = null;
        x.tagList = ["b", "caption", "cite", "code", "dd", "del", "div", "dfn", "dt", "em", "h1", "h2", "h3", "h4", "h5", "h6", "ins", "kdb", "label", "li", "output", "p", "q", "s", "sample", "span", "strong", "td", "th", "u", "var"];
        var B = x.vMax.toString().split("."), w = (!x.vMin && x.vMin !== 0) ? [] : x.vMin.toString().split(".");
        b(x, "vMax");
        b(x, "vMin");
        b(x, "mDec");
        x.mDec = (x.mRound === "CHF") ? "2" : x.mDec;
        x.allowLeading = true;
        x.aNeg = x.vMin < 0 ? "-" : "";
        B[0] = B[0].replace("-", "");
        w[0] = w[0].replace("-", "");
        x.mInt = Math.max(B[0].length, w[0].length, 1);
        if (x.mDec === null) {
            var A = 0, v = 0;
            if (B[1]) {
                A = B[1].length
            }
            if (w[1]) {
                v = w[1].length
            }
            x.mDec = Math.max(A, v)
        }
        if (x.altDec === null && x.mDec > 0) {
            if (x.aDec === "." && x.aSep !== ",") {
                x.altDec = ","
            } else {
                if (x.aDec === "," && x.aSep !== ".") {
                    x.altDec = "."
                }
            }
        }
        var u = x.aNeg ? "([-\\" + x.aNeg + "]?)" : "(-?)";
        x.aNegRegAutoStrip = u;
        x.skipFirstAutoStrip = new RegExp(u + "[^-" + (x.aNeg ? "\\" + x.aNeg : "") + "\\" + x.aDec + "\\d].*?(\\d|\\" + x.aDec + "\\d)");
        x.skipLastAutoStrip = new RegExp("(\\d\\" + x.aDec + "?)[^\\" + x.aDec + "\\d]\\D*$");
        var z = "-" + x.aNum + "\\" + x.aDec;
        x.allowedAutoStrip = new RegExp("[^" + z + "]", "gi");
        x.numRegAutoStrip = new RegExp(u + "(?:\\" + x.aDec + "?(\\d+\\" + x.aDec + "\\d+)|(\\d*(?:\\" + x.aDec + "\\d*)?))");
        return x
    }

    function l(x, w, A) {
        if (w.aSign) {
            while (x.indexOf(w.aSign) > -1) {
                x = x.replace(w.aSign, "")
            }
        }
        x = x.replace(w.skipFirstAutoStrip, "$1$2");
        x = x.replace(w.skipLastAutoStrip, "$1");
        x = x.replace(w.allowedAutoStrip, "");
        if (w.altDec) {
            x = x.replace(w.altDec, w.aDec)
        }
        var u = x.match(w.numRegAutoStrip);
        x = u ? [u[1], u[2], u[3]].join("") : "";
        if ((w.lZero === "allow" || w.lZero === "keep") && A !== "strip") {
            var y = [], z = "";
            y = x.split(w.aDec);
            if (y[0].indexOf("-") !== -1) {
                z = "-";
                y[0] = y[0].replace("-", "")
            }
            if (y[0].length > w.mInt && y[0].charAt(0) === "0") {
                y[0] = y[0].slice(1)
            }
            x = z + y.join(w.aDec)
        }
        if ((A && w.lZero === "deny") || (A && w.lZero === "allow" && w.allowLeading === false)) {
            var v = "^" + w.aNegRegAutoStrip + "0*(\\d" + (A === "leading" ? ")" : "|$)");
            v = new RegExp(v);
            x = x.replace(v, "$1$2")
        }
        return x
    }

    function d(v, w, u) {
        w = w.split(",");
        if (u === "set" || u === "focusout") {
            v = v.replace("-", "");
            v = w[0] + v + w[1]
        } else {
            if ((u === "get" || u === "focusin" || u === "pageLoad") && v.charAt(0) === w[0]) {
                v = v.replace(w[0], "-");
                v = v.replace(w[1], "")
            }
        }
        return v
    }

    function n(v, u, x) {
        if (u && x) {
            var w = v.split(u);
            if (w[1] && w[1].length > x) {
                if (x > 0) {
                    w[1] = w[1].substring(0, x);
                    v = w.join(u)
                } else {
                    v = w[0]
                }
            }
        }
        return v
    }

    function m(w, v, u) {
        if (v && v !== ".") {
            w = w.replace(v, ".")
        }
        if (u && u !== "-") {
            w = w.replace(u, "-")
        }
        if (!w.match(/\d/)) {
            w += "0"
        }
        return w
    }

    function a(w, v) {
        if (w) {
            var u = +w;
            if (u < 0.000001 && u > -1) {
                w = +w;
                if (w < 0.000001 && w > 0) {
                    w = (w + 10).toString();
                    w = w.substring(1)
                }
                if (w < 0 && w > -1) {
                    w = (w - 10).toString();
                    w = "-" + w.substring(2)
                }
                w = w.toString()
            } else {
                var x = w.split(".");
                if (x[1] !== undefined) {
                    if (+x[1] === 0) {
                        w = x[0]
                    } else {
                        x[1] = x[1].replace(/0*$/, "");
                        w = x.join(".")
                    }
                }
            }
        }
        return (v.lZero === "keep") ? w : w.replace(/^0*(\d)/, "$1")
    }

    function i(w, v, u) {
        if (u && u !== "-") {
            w = w.replace("-", u)
        }
        if (v && v !== ".") {
            w = w.replace(".", v)
        }
        return w
    }

    function o(v, u) {
        v = l(v, u);
        v = n(v, u.aDec, u.mDec);
        v = m(v, u.aDec, u.aNeg);
        var w = +v;
        if (u.oEvent === "set" && (w < u.vMin || w > u.vMax)) {
            c.error("The value (" + w + ") from the 'set' method falls outside of the vMin / vMax range")
        }
        return w >= u.vMin && w <= u.vMax
    }

    function q(v, w, u) {
        if (v === "" || v === w.aNeg) {
            if (w.wEmpty === "zero") {
                return v + "0"
            }
            if (w.wEmpty === "sign" || u) {
                return v + w.aSign
            }
            return v
        }
        return null
    }

    function f(w, A) {
        w = l(w, A);
        var z = w.replace(",", "."), B = q(w, A, true);
        if (B !== null) {
            return B
        }
        var u = "";
        if (A.dGroup === 2) {
            u = /(\d)((\d)(\d{2}?)+)$/
        } else {
            if (A.dGroup === 4) {
                u = /(\d)((\d{4}?)+)$/
            } else {
                u = /(\d)((\d{3}?)+)$/
            }
        }
        var y = w.split(A.aDec);
        if (A.altDec && y.length === 1) {
            y = w.split(A.altDec)
        }
        var x = y[0];
        if (A.aSep) {
            while (u.test(x)) {
                x = x.replace(u, "$1" + A.aSep + "$2")
            }
        }
        if (A.mDec !== 0 && y.length > 1) {
            if (y[1].length > A.mDec) {
                y[1] = y[1].substring(0, A.mDec)
            }
            w = x + A.aDec + y[1]
        } else {
            w = x
        }
        if (A.aSign) {
            var v = w.indexOf(A.aNeg) !== -1;
            w = w.replace(A.aNeg, "");
            w = A.pSign === "p" ? A.aSign + w : w + A.aSign;
            if (v) {
                w = A.aNeg + w
            }
        }
        if (A.oEvent === "set" && z < 0 && A.nBracket !== null) {
            w = d(w, A.nBracket, A.oEvent)
        }
        return w
    }

    function r(A, z) {
        A = (A === "") ? "0" : A.toString();
        b(z, "mDec");
        if (z.mRound === "CHF") {
            A = (Math.round(A * 20) / 20).toString()
        }
        var u = "", E = 0, J = "", G = (typeof(z.aPad) === "boolean" || z.aPad === null) ? (z.aPad ? z.mDec : 0) : +z.aPad;
        var v = function (K) {
            var L = (G === 0) ? (/(\.(?:\d*[1-9])?)0*$/) : G === 1 ? (/(\.\d(?:\d*[1-9])?)0*$/) : new RegExp("(\\.\\d{" + G + "}(?:\\d*[1-9])?)0*$");
            K = K.replace(L, "$1");
            if (G === 0) {
                K = K.replace(/\.$/, "")
            }
            return K
        };
        if (A.charAt(0) === "-") {
            J = "-";
            A = A.replace("-", "")
        }
        if (!A.match(/^\d/)) {
            A = "0" + A
        }
        if (J === "-" && +A === 0) {
            J = ""
        }
        if ((+A > 0 && z.lZero !== "keep") || (A.length > 0 && z.lZero === "allow")) {
            A = A.replace(/^0*(\d)/, "$1")
        }
        var H = A.lastIndexOf("."), D = (H === -1) ? A.length - 1 : H, F = (A.length - 1) - D;
        if (F <= z.mDec) {
            u = A;
            if (F < G) {
                if (H === -1) {
                    u += "."
                }
                var w = "000000";
                while (F < G) {
                    w = w.substring(0, G - F);
                    u += w;
                    F += w.length
                }
            } else {
                if (F > G) {
                    u = v(u)
                } else {
                    if (F === 0 && G === 0) {
                        u = u.replace(/\.$/, "")
                    }
                }
            }
            if (z.mRound !== "CHF") {
                return (+u === 0) ? u : J + u
            }
            if (z.mRound === "CHF") {
                H = u.lastIndexOf(".");
                A = u
            }
        }
        var x = H + z.mDec, y = +A.charAt(x + 1), C = A.substring(0, x + 1).split(""), I = (A.charAt(x) === ".") ? (A.charAt(x - 1) % 2) : (A.charAt(x) % 2), B = true;
        if (I !== 1) {
            I = (I === 0 && (A.substring(x + 2, A.length) > 0)) ? 1 : 0
        }
        if ((y > 4 && z.mRound === "S") || (y > 4 && z.mRound === "A" && J === "") || (y > 5 && z.mRound === "A" && J === "-") || (y > 5 && z.mRound === "s") || (y > 5 && z.mRound === "a" && J === "") || (y > 4 && z.mRound === "a" && J === "-") || (y > 5 && z.mRound === "B") || (y === 5 && z.mRound === "B" && I === 1) || (y > 0 && z.mRound === "C" && J === "") || (y > 0 && z.mRound === "F" && J === "-") || (y > 0 && z.mRound === "U") || (z.mRound === "CHF")) {
            for (E = (C.length - 1); E >= 0; E -= 1) {
                if (C[E] !== ".") {
                    if (z.mRound === "CHF" && C[E] <= 2 && B) {
                        C[E] = 0;
                        B = false;
                        break
                    }
                    if (z.mRound === "CHF" && C[E] <= 7 && B) {
                        C[E] = 5;
                        B = false;
                        break
                    }
                    if (z.mRound === "CHF" && B) {
                        C[E] = 10;
                        B = false
                    } else {
                        C[E] = +C[E] + 1
                    }
                    if (C[E] < 10) {
                        break
                    }
                    if (E > 0) {
                        C[E] = "0"
                    }
                }
            }
        }
        C = C.slice(0, x + 1);
        u = v(C.join(""));
        return (+u === 0) ? u : J + u
    }

    function k(v, u) {
        this.settings = u;
        this.that = v;
        this.$that = c(v);
        this.formatted = false;
        this.settingsClone = s(this.$that, this.settings);
        this.value = v.value
    }

    k.prototype = {
        init: function (u) {
            this.value = this.that.value;
            this.settingsClone = s(this.$that, this.settings);
            this.ctrlKey = u.ctrlKey;
            this.cmdKey = u.metaKey;
            this.shiftKey = u.shiftKey;
            this.selection = e(this.that);
            if (u.type === "keydown" || u.type === "keyup") {
                this.kdCode = u.keyCode
            }
            this.which = u.which;
            this.processed = false;
            this.formatted = false
        }, setSelection: function (w, u, v) {
            w = Math.max(w, 0);
            u = Math.min(u, this.that.value.length);
            this.selection = {start: w, end: u, length: u - w};
            if (v === undefined || v) {
                t(this.that, w, u)
            }
        }, setPosition: function (v, u) {
            this.setSelection(v, v, u)
        }, getBeforeAfter: function () {
            var v = this.value, w = v.substring(0, this.selection.start), u = v.substring(this.selection.end, v.length);
            return [w, u]
        }, getBeforeAfterStriped: function () {
            var u = this.getBeforeAfter();
            u[0] = l(u[0], this.settingsClone);
            u[1] = l(u[1], this.settingsClone);
            return u
        }, normalizeParts: function (z, x) {
            var v = this.settingsClone;
            x = l(x, v);
            var y = x.match(/^\d/) ? true : "leading";
            z = l(z, v, y);
            if ((z === "" || z === v.aNeg) && v.lZero === "deny") {
                if (x > "") {
                    x = x.replace(/^0*(\d)/, "$1")
                }
            }
            var w = z + x;
            if (v.aDec) {
                var u = w.match(new RegExp("^" + v.aNegRegAutoStrip + "\\" + v.aDec));
                if (u) {
                    z = z.replace(u[1], u[1] + "0");
                    w = z + x
                }
            }
            if (v.wEmpty === "zero" && (w === v.aNeg || w === "")) {
                z += "0"
            }
            return [z, x]
        }, setValueParts: function (z, x) {
            var v = this.settingsClone, y = this.normalizeParts(z, x), w = y.join(""), u = y[0].length;
            if (o(w, v)) {
                w = n(w, v.aDec, v.mDec);
                if (u > w.length) {
                    u = w.length
                }
                this.value = w;
                this.setPosition(u, false);
                return true
            }
            return false
        }, signPosition: function () {
            var v = this.settingsClone, y = v.aSign, x = this.that;
            if (y) {
                var w = y.length;
                if (v.pSign === "p") {
                    var z = v.aNeg && x.value && x.value.charAt(0) === v.aNeg;
                    return z ? [1, w + 1] : [0, w]
                }
                var u = x.value.length;
                return [u - w, u]
            }
            return [1000, -1]
        }, expandSelectionOnSign: function (v) {
            var u = this.signPosition(), w = this.selection;
            if (w.start < u[1] && w.end > u[0]) {
                if ((w.start < u[0] || w.end > u[1]) && this.value.substring(Math.max(w.start, u[0]), Math.min(w.end, u[1])).match(/^\s*$/)) {
                    if (w.start < u[0]) {
                        this.setSelection(w.start, u[0], v)
                    } else {
                        this.setSelection(u[1], w.end, v)
                    }
                } else {
                    this.setSelection(Math.min(w.start, u[0]), Math.max(w.end, u[1]), v)
                }
            }
        }, checkPaste: function () {
            if (this.valuePartsBeforePaste !== undefined) {
                var v = this.getBeforeAfter(), u = this.valuePartsBeforePaste;
                delete this.valuePartsBeforePaste;
                v[0] = v[0].substr(0, u[0].length) + l(v[0].substr(u[0].length), this.settingsClone);
                if (!this.setValueParts(v[0], v[1])) {
                    this.value = u.join("");
                    this.setPosition(u[0].length, false)
                }
            }
        }, skipAllways: function (x) {
            var y = this.kdCode, w = this.which, v = this.ctrlKey, B = this.cmdKey, z = this.shiftKey;
            if (((v || B) && x.type === "keyup" && this.valuePartsBeforePaste !== undefined) || (z && y === 45)) {
                this.checkPaste();
                return false
            }
            if ((y >= 112 && y <= 123) || (y >= 91 && y <= 93) || (y >= 9 && y <= 31) || (y < 8 && (w === 0 || w === y)) || y === 144 || y === 145 || y === 45) {
                return true
            }
            if ((v || B) && y === 65) {
                return true
            }
            if ((v || B) && (y === 67 || y === 86 || y === 88)) {
                if (x.type === "keydown") {
                    this.expandSelectionOnSign()
                }
                if (y === 86 || y === 45) {
                    if (x.type === "keydown" || x.type === "keypress") {
                        if (this.valuePartsBeforePaste === undefined) {
                            this.valuePartsBeforePaste = this.getBeforeAfter()
                        }
                    } else {
                        this.checkPaste()
                    }
                }
                return x.type === "keydown" || x.type === "keypress" || y === 67
            }
            if (v || B) {
                return true
            }
            if (y === 37 || y === 39) {
                var A = this.settingsClone.aSep, u = this.selection.start, C = this.that.value;
                if (x.type === "keydown" && A && !this.shiftKey) {
                    if (y === 37 && C.charAt(u - 2) === A) {
                        this.setPosition(u - 1)
                    } else {
                        if (y === 39 && C.charAt(u + 1) === A) {
                            this.setPosition(u + 1)
                        }
                    }
                }
                return true
            }
            if (y >= 34 && y <= 40) {
                return true
            }
            return false
        }, processAllways: function () {
            var u;
            if (this.kdCode === 8 || this.kdCode === 46) {
                if (!this.selection.length) {
                    u = this.getBeforeAfterStriped();
                    if (this.kdCode === 8) {
                        u[0] = u[0].substring(0, u[0].length - 1)
                    } else {
                        u[1] = u[1].substring(1, u[1].length)
                    }
                    this.setValueParts(u[0], u[1])
                } else {
                    this.expandSelectionOnSign(false);
                    u = this.getBeforeAfterStriped();
                    this.setValueParts(u[0], u[1])
                }
                return true
            }
            return false
        }, processKeypress: function () {
            var u = this.settingsClone, v = String.fromCharCode(this.which), y = this.getBeforeAfterStriped(), x = y[0], w = y[1];
            if (v === u.aDec || (u.altDec && v === u.altDec) || ((v === "." || v === ",") && this.kdCode === 110)) {
                if (!u.mDec || !u.aDec) {
                    return true
                }
                if (u.aNeg && w.indexOf(u.aNeg) > -1) {
                    return true
                }
                if (x.indexOf(u.aDec) > -1) {
                    return true
                }
                if (w.indexOf(u.aDec) > 0) {
                    return true
                }
                if (w.indexOf(u.aDec) === 0) {
                    w = w.substr(1)
                }
                this.setValueParts(x + u.aDec, w);
                return true
            }
            if (v === "-" || v === "+") {
                if (!u.aNeg) {
                    return true
                }
                if (x === "" && w.indexOf(u.aNeg) > -1) {
                    x = u.aNeg;
                    w = w.substring(1, w.length)
                }
                if (x.charAt(0) === u.aNeg) {
                    x = x.substring(1, x.length)
                } else {
                    x = (v === "-") ? u.aNeg + x : x
                }
                this.setValueParts(x, w);
                return true
            }
            if (v >= "0" && v <= "9") {
                if (u.aNeg && x === "" && w.indexOf(u.aNeg) > -1) {
                    x = u.aNeg;
                    w = w.substring(1, w.length)
                }
                if (u.vMax <= 0 && u.vMin < u.vMax && this.value.indexOf(u.aNeg) === -1 && v !== "0") {
                    x = u.aNeg + x
                }
                this.setValueParts(x + v, w);
                return true
            }
            return true
        }, formatQuick: function () {
            var C = this.settingsClone, v = this.getBeforeAfterStriped(), D = this.value;
            if ((C.aSep === "" || (C.aSep !== "" && D.indexOf(C.aSep) === -1)) && (C.aSign === "" || (C.aSign !== "" && D.indexOf(C.aSign) === -1))) {
                var u = [], E = "";
                u = D.split(C.aDec);
                if (u[0].indexOf("-") > -1) {
                    E = "-";
                    u[0] = u[0].replace("-", "");
                    v[0] = v[0].replace("-", "")
                }
                if (u[0].length > C.mInt && v[0].charAt(0) === "0") {
                    v[0] = v[0].slice(1)
                }
                v[0] = E + v[0]
            }
            var B = f(this.value, this.settingsClone), x = B.length;
            if (B) {
                var y = v[0].split(""), w = 0;
                for (w; w < y.length; w += 1) {
                    if (!y[w].match("\\d")) {
                        y[w] = "\\" + y[w]
                    }
                }
                var z = new RegExp("^.*?" + y.join(".*?"));
                var A = B.match(z);
                if (A) {
                    x = A[0].length;
                    if (((x === 0 && B.charAt(0) !== C.aNeg) || (x === 1 && B.charAt(0) === C.aNeg)) && C.aSign && C.pSign === "p") {
                        x = this.settingsClone.aSign.length + (B.charAt(0) === "-" ? 1 : 0)
                    }
                } else {
                    if (C.aSign && C.pSign === "s") {
                        x -= C.aSign.length
                    }
                }
            }
            this.that.value = B;
            this.setPosition(x);
            this.formatted = true
        }
    };
    function g(u) {
        if (typeof u === "string") {
            u = u.replace(/\[/g, "\\[").replace(/\]/g, "\\]");
            u = "#" + u.replace(/(:|\.)/g, "\\$1")
        }
        return c(u)
    }

    function h(u, w, y) {
        var x = u.data("autoNumeric");
        if (!x) {
            x = {};
            u.data("autoNumeric", x)
        }
        var v = x.holder;
        if ((v === undefined && w) || y) {
            v = new k(u.get(0), w);
            x.holder = v
        }
        return v
    }

    var p = {
        init: function (u) {
            return this.each(function () {
                var z = c(this), w = z.data("autoNumeric"), y = z.data();
                if (typeof w !== "object") {
                    var x = {
                        aNum: "0123456789",
                        aSep: ",",
                        dGroup: "3",
                        aDec: ".",
                        altDec: null,
                        aSign: "",
                        pSign: "p",
                        vMax: "9999999999999.99",
                        vMin: "0.00",
                        mDec: null,
                        mRound: "S",
                        aPad: true,
                        nBracket: null,
                        wEmpty: "empty",
                        lZero: "allow",
                        aForm: true,
                        onSomeEvent: function () {
                        }
                    };
                    w = c.extend({}, x, y, u);
                    if (w.aDec === w.aSep) {
                        c.error("autoNumeric will not function properly when the decimal character aDec: '" + w.aDec + "' and thousand separator aSep: '" + w.aSep + "' are the same character");
                        return this
                    }
                    z.data("autoNumeric", w)
                } else {
                    return this
                }
                w.runOnce = false;
                var v = h(z, w);
                if (c.inArray(z.prop("tagName").toLowerCase(), w.tagList) === -1 && z.prop("tagName").toLowerCase() !== "input") {
                    c.error("The <" + z.prop("tagName").toLowerCase() + "> is not supported by autoNumeric()");
                    return this
                }
                if (w.runOnce === false && w.aForm) {
                    if (z.is("input[type=text], input[type=hidden], input[type=tel], input:not([type])")) {
                        var A = true;
                        if (z[0].value === "" && w.wEmpty === "empty") {
                            z[0].value = "";
                            A = false
                        }
                        if (z[0].value === "" && w.wEmpty === "sign") {
                            z[0].value = w.aSign;
                            A = false
                        }
                        if (A) {
                            z.autoNumeric("set", z.val())
                        }
                    }
                    if (c.inArray(z.prop("tagName").toLowerCase(), w.tagList) !== -1 && z.text() !== "") {
                        z.autoNumeric("set", z.text())
                    }
                }
                w.runOnce = true;
                if (z.is("input[type=text], input[type=hidden], input[type=tel], input:not([type])")) {
                    z.on("keydown.autoNumeric", function (B) {
                        v = h(z);
                        if (v.settings.aDec === v.settings.aSep) {
                            c.error("autoNumeric will not function properly when the decimal character aDec: '" + v.settings.aDec + "' and thousand separator aSep: '" + v.settings.aSep + "' are the same character");
                            return this
                        }
                        if (v.that.readOnly) {
                            v.processed = true;
                            return true
                        }
                        v.init(B);
                        v.settings.oEvent = "keydown";
                        if (v.skipAllways(B)) {
                            v.processed = true;
                            return true
                        }
                        if (v.processAllways()) {
                            v.processed = true;
                            v.formatQuick();
                            B.preventDefault();
                            return false
                        }
                        v.formatted = false;
                        return true
                    });
                    z.on("keypress.autoNumeric", function (C) {
                        var B = h(z), D = B.processed;
                        B.init(C);
                        B.settings.oEvent = "keypress";
                        if (B.skipAllways(C)) {
                            return true
                        }
                        if (D) {
                            C.preventDefault();
                            return false
                        }
                        if (B.processAllways() || B.processKeypress()) {
                            B.formatQuick();
                            C.preventDefault();
                            return false
                        }
                        B.formatted = false
                    });
                    z.on("keyup.autoNumeric", function (D) {
                        var B = h(z);
                        B.init(D);
                        B.settings.oEvent = "keyup";
                        var C = B.skipAllways(D);
                        B.kdCode = 0;
                        delete B.valuePartsBeforePaste;
                        if (z[0].value === B.settings.aSign) {
                            if (B.settings.pSign === "s") {
                                t(this, 0, 0)
                            } else {
                                t(this, B.settings.aSign.length, B.settings.aSign.length)
                            }
                        }
                        if (C) {
                            return true
                        }
                        if (this.value === "") {
                            return true
                        }
                        if (!B.formatted) {
                            B.formatQuick()
                        }
                    });
                    z.on("focusin.autoNumeric", function () {
                        var C = h(z);
                        C.settingsClone.oEvent = "focusin";
                        if (C.settingsClone.nBracket !== null) {
                            var D = z.val();
                            z.val(d(D, C.settingsClone.nBracket, C.settingsClone.oEvent))
                        }
                        C.inVal = z.val();
                        var B = q(C.inVal, C.settingsClone, true);
                        if (B !== null) {
                            z.val(B);
                            if (C.settings.pSign === "s") {
                                t(this, 0, 0)
                            } else {
                                t(this, C.settings.aSign.length, C.settings.aSign.length)
                            }
                        }
                    });
                    z.on("focusout.autoNumeric", function () {
                        var D = h(z), C = D.settingsClone, F = z.val(), B = F;
                        D.settingsClone.oEvent = "focusout";
                        var G = "";
                        if (C.lZero === "allow") {
                            C.allowLeading = false;
                            G = "leading"
                        }
                        if (F !== "") {
                            F = l(F, C, G);
                            if (q(F, C) === null && o(F, C, z[0])) {
                                F = m(F, C.aDec, C.aNeg);
                                F = r(F, C);
                                F = i(F, C.aDec, C.aNeg)
                            } else {
                                F = ""
                            }
                        }
                        var E = q(F, C, false);
                        if (E === null) {
                            E = f(F, C)
                        }
                        if (E !== B) {
                            z.val(E)
                        }
                        if (E !== D.inVal) {
                            z.change();
                            delete D.inVal
                        }
                        if (C.nBracket !== null && z.autoNumeric("get") < 0) {
                            D.settingsClone.oEvent = "focusout";
                            z.val(d(z.val(), C.nBracket, C.oEvent))
                        }
                    })
                }
            })
        }, destroy: function () {
            return c(this).each(function () {
                var u = c(this);
                u.off(".autoNumeric");
                u.removeData("autoNumeric")
            })
        }, update: function (u) {
            return c(this).each(function () {
                var x = g(c(this)), w = x.data("autoNumeric");
                if (typeof w !== "object") {
                    c.error("You must initialize autoNumeric('init', {options}) prior to calling the 'update' method");
                    return this
                }
                var v = x.autoNumeric("get");
                w = c.extend(w, u);
                h(x, w, true);
                if (w.aDec === w.aSep) {
                    c.error("autoNumeric will not function properly when the decimal character aDec: '" + w.aDec + "' and thousand separator aSep: '" + w.aSep + "' are the same character");
                    return this
                }
                x.data("autoNumeric", w);
                if (x.val() !== "" || x.text() !== "") {
                    return x.autoNumeric("set", v)
                }

            })
        }, set: function (u) {
            if (u === null) {
                return
            }
            return c(this).each(function () {
                var y = g(c(this)), v = y.data("autoNumeric"), w = u.toString(), x = u.toString();
                if (typeof v !== "object") {
                    c.error("You must initialize autoNumeric('init', {options}) prior to calling the 'set' method");
                    return this
                }
                if (x !== y.attr("value") && y.prop("tagName").toLowerCase() === "input" && v.runOnce === false) {
                    w = (v.nBracket !== null) ? d(y.val(), v.nBracket, "pageLoad") : w;
                    w = l(w, v)
                }
                if ((x === y.attr("value") || x === y.text()) && v.runOnce === false) {
                    w = w.replace(",", ".")
                }
                if (!c.isNumeric(+w)) {
                    return ""
                }
                w = a(w, v);
                v.oEvent = "set";
                w.toString();
                if (w !== "") {
                    w = r(w, v)
                }
                w = i(w, v.aDec, v.aNeg);
                if (!o(w, v)) {
                    w = r("", v)
                }
                w = f(w, v);
                if (y.is("input[type=text], input[type=hidden], input[type=tel], input:not([type])")) {
                    return y.val(w)
                }
                if (c.inArray(y.prop("tagName").toLowerCase(), v.tagList) !== -1) {
                    return y.text(w)
                }
                c.error("The <" + y.prop("tagName").toLowerCase() + "> is not supported by autoNumeric()");
                return false
            })
        }, get: function () {
            var w = g(c(this)), v = w.data("autoNumeric");
            if (typeof v !== "object") {
                c.error("You must initialize autoNumeric('init', {options}) prior to calling the 'get' method");
                return this
            }
            v.oEvent = "get";
            var u = "";
            if (w.is("input[type=text], input[type=hidden], input[type=tel], input:not([type])")) {
                u = w.eq(0).val()
            } else {
                if (c.inArray(w.prop("tagName").toLowerCase(), v.tagList) !== -1) {
                    u = w.eq(0).text()
                } else {
                    c.error("The <" + w.prop("tagName").toLowerCase() + "> is not supported by autoNumeric()");
                    return false
                }
            }
            if ((u === "" && v.wEmpty === "empty") || (u === v.aSign && (v.wEmpty === "sign" || v.wEmpty === "empty"))) {
                return ""
            }
            if (v.nBracket !== null && u !== "") {
                u = d(u, v.nBracket, v.oEvent)
            }
            if (v.runOnce || v.aForm === false) {
                u = l(u, v)
            }
            u = m(u, v.aDec, v.aNeg);
            if (+u === 0 && v.lZero !== "keep") {
                u = "0"
            }
            if (v.lZero === "keep") {
                return u
            }
            u = a(u, v);
            return u
        }, getString: function () {
            var C = false, z = g(c(this)), y = z.serialize(), w = y.split("&"), B = c("form").index(z), x = 0;
            for (x; x < w.length; x += 1) {
                var v = w[x].split("="), A = c("form:eq(" + B + ') input[name="' + decodeURIComponent(v[0]) + '"]'), u = A.data("autoNumeric");
                if (typeof u === "object") {
                    if (v[1] !== null) {
                        v[1] = A.autoNumeric("get");
                        w[x] = v.join("=");
                        C = true
                    }
                }
            }
            if (C === true) {
                return w.join("&")
            }
            return y
        }, getArray: function () {
            var w = false, x = g(c(this)), v = x.serializeArray(), u = c("form").index(x);
            c.each(v, function (y, B) {
                var A = c("form:eq(" + u + ') input[name="' + decodeURIComponent(B.name) + '"]'), z = A.data("autoNumeric");
                if (typeof z === "object") {
                    if (B.value !== "") {
                        B.value = A.autoNumeric("get").toString()
                    }
                    w = true
                }
            });
            if (w === true) {
                return v
            }
            return this
        }, getSettings: function () {
            var u = g(c(this));
            return u.eq(0).data("autoNumeric")
        }
    };
    c.fn.autoNumeric = function (u) {
        if (p[u]) {
            return p[u].apply(this, Array.prototype.slice.call(arguments, 1))
        }
        if (typeof u === "object" || !u) {
            return p.init.apply(this, arguments)
        }
        c.error('Method "' + u + '" is not supported by autoNumeric()')
    }
}(jQuery));