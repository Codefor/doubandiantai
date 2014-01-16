var Zepto = function() {
    function n(c) {
        return c.filter(function(d) {
            return d !== b && d !== null
        })
    }
    function p(d, c) {
        this.dom = d || [];
        this.selector = c || ""
    }
    function r(d, c) {
        return d == document ? new p : c !== b ? r(c).find(d) : new p(n(d instanceof p ? d.dom : d instanceof Array ? d : d instanceof Element ? [d] : q.call(o.querySelectorAll(d))), d)
    }
    var q = [].slice, o = document, j = {append: "beforeEnd",prepend: "afterBegin",before: "beforeBegin",after: "afterEnd"}, k, a, b;
    if (String.prototype.trim === b) {
        String.prototype.trim = function() {
            return this.replace(/^\s+/, "").replace(/\s+$/, "")
        }
    }
    p.prototype = r.fn;
    r.extend = function(d, c) {
        for (k in c) {
            d[k] = c[k]
        }
    };
    camelize = function(c) {
        return c.replace(/-+(.)?/g, function(d, e) {
            return e ? e.toUpperCase() : ""
        })
    };
    r.fn = {ready: function(c) {
            document.addEventListener("DOMContentLoaded", c, false);
            return this
        },compact: function() {
            this.dom = n(this.dom);
            return this
        },get: function(c) {
            return c === b ? this.dom : this.dom[c]
        },remove: function() {
            return this.each(function(c) {
                c.parentNode.removeChild(c)
            })
        },each: function(c) {
            this.dom.forEach(c);
            return this
        },filter: function(c) {
            return r(this.dom.filter(function(d) {
                return q.call(d.parentNode.querySelectorAll(c)).indexOf(d) >= 0
            }))
        },is: function(c) {
            return this.dom.length > 0 && r(this.dom[0]).filter(c).dom.length > 0
        },first: function() {
            this.dom = n([this.dom[0]]);
            return this
        },find: function(c) {
            return r(this.dom.map(function(d) {
                return q.call(d.querySelectorAll(c))
            }).reduce(function(d, e) {
                return d.concat(e)
            }, []))
        },closest: function(d) {
            var c = this.dom[0].parentNode;
            for (d = q.call(o.querySelectorAll(d)); c && d.indexOf(c) < 0; ) {
                c = c.parentNode
            }
            return r(c && c !== o ? c : [])
        },pluck: function(c) {
            return this.dom.map(function(d) {
                return d[c]
            })
        },show: function() {
            return this.css("display", "block")
        },hide: function() {
            return this.css("display", "none")
        },prev: function() {
            return r(this.pluck("previousElementSibling"))
        },next: function() {
            return r(this.pluck("nextElementSibling"))
        },html: function(c) {
            return c === b ? this.dom.length > 0 ? this.dom[0].innerHTML : null : this.each(function(d) {
                d.innerHTML = c
            })
        },attr: function(d, c) {
            return typeof d == "string" && c === b ? this.dom.length > 0 ? this.dom[0].getAttribute(d) || undefined : null : this.each(function(e) {
                if (typeof d == "object") {
                    for (k in d) {
                        e.setAttribute(k, d[k])
                    }
                } else {
                    e.setAttribute(d, c)
                }
            })
        },offset: function() {
            var c = this.dom[0].getBoundingClientRect();
            return {left: c.left + o.body.scrollLeft,top: c.top + o.body.scrollTop,width: c.width,height: c.height}
        },css: function(d, c) {
            if (c === b && typeof d == "string") {
                return this.dom[0].style[camelize(d)]
            }
            a = "";
            for (k in d) {
                a += k + ":" + d[k] + ";"
            }
            if (typeof d == "string") {
                a = d + ":" + c
            }
            return this.each(function(e) {
                e.style.cssText += ";" + a
            })
        },index: function(c) {
            return this.dom.indexOf(r(c).get(0))
        },bind: function(d, c) {
            return this.each(function(e) {
                d.split(/\s/).forEach(function(f) {
                    e.addEventListener(f, c, false)
                })
            })
        },delegate: function(d, c, e) {
            return this.each(function(f) {
                f.addEventListener(c, function(i) {
                    for (var g = i.target, h = q.call(f.querySelectorAll(d)); g && h.indexOf(g) < 0; ) {
                        g = g.parentNode
                    }
                    g && g !== f && g !== o && e(g, i)
                }, false)
            })
        },live: function(d, c) {
            r(o.body).delegate(this.selector, d, c);
            return this
        },hasClass: function(c) {
            return RegExp("(^|\\s)" + c + "(\\s|$)").test(this.dom[0].className)
        },addClass: function(c) {
            return this.each(function(d) {
                !r(d).hasClass(c) && (d.className += (d.className ? " " : "") + c)
            })
        },removeClass: function(c) {
            return this.each(function(d) {
                d.className = d.className.replace(RegExp("(^|\\s)" + c + "(\\s|$)"), " ").trim()
            })
        },trigger: function(c) {
            return this.each(function(d) {
                var e;
                d.dispatchEvent(e = o.createEvent("Events"), e.initEvent(c, true, false))
            })
        }};
    ["width", "height"].forEach(function(c) {
        r.fn[c] = function() {
            return this.offset()[c]
        }
    });
    for (k in j) {
        r.fn[k] = function(c) {
            return function(d) {
                return this.each(function(e) {
                    e["insertAdjacent" + (d instanceof Element ? "Element" : "HTML")](c, d)
                })
            }
        }(j[k])
    }
    p.prototype = r.fn;
    return r
}();
"$" in window || (window.$ = Zepto);
(function(a) {
    function b(l) {
        var k = {}, j = l.match(/(Android)\s+([0-9\.]+)/), e = l.match(/(iPhone\sOS)\s([0-9_]+)/), g = l.match(/(iPad).*OS\s([0-9_]+)/);
        l = l.match(/(webOS)\/([0-9\.]+)/);
        if (j) {
            k.android = true;
            k.version = j[2]
        }
        if (e) {
            k.ios = true;
            k.version = e[2].replace(/_/g, ".");
            k.iphone = true
        }
        if (g) {
            k.ios = true;
            k.version = g[2].replace(/_/g, ".");
            k.ipad = true
        }
        if (l) {
            k.webos = true;
            k.version = l[2]
        }
        return k
    }
    a.os = b(navigator.userAgent);
    a.__detect = b
})(Zepto);
(function(a) {
    a.fn.anim = function(k, m, l) {
        var j = [], b, g;
        for (g in k) {
            g === "opacity" ? b = k[g] : j.push(g + "(" + k[g] + ")")
        }
        return this.css({"-webkit-transition": "all " + (m || 0.5) + "s " + (l || ""),"-webkit-transform": j.join(" "),opacity: b})
    }
})(Zepto);
(function(a) {
    var b = {}, d;
    a(document).ready(function() {
        a(document.body).bind("touchstart", function(g) {
            var e = Date.now(), c = e - (b.last || e);
            b.target = "tagName" in g.touches[0].target ? g.touches[0].target : g.touches[0].target.parentNode;
            d && clearTimeout(d);
            b.x1 = g.touches[0].pageX;
            if (c > 0 && c <= 250) {
                b.isDoubleTap = true
            }
            b.last = e
        }).bind("touchmove", function(c) {
            b.x2 = c.touches[0].pageX
        }).bind("touchend", function() {
            if (b.isDoubleTap) {
                a(b.target).trigger("doubleTap");
                b = {}
            } else {
                if (b.x2 > 0) {
                    Math.abs(b.x1 - b.x2) > 30 && a(b.target).trigger("swipe");
                    b.x1 = b.x2 = b.last = 0
                } else {
                    if ("last" in b) {
                        d = setTimeout(function() {
                            d = null;
                            a(b.target).trigger("tap");
                            b = {}
                        }, 250)
                    }
                }
            }
        }).bind("touchcancel", function() {
            b = {}
        })
    });
    ["swipe", "doubleTap", "tap"].forEach(function(c) {
        a.fn[c] = function(e) {
            return this.bind(c, e)
        }
    })
})(Zepto);
(function(a) {
    function b(j, h, g) {
        var e = new XMLHttpRequest;
        e.onreadystatechange = function() {
            if (e.readyState == 4 && (e.status == 200 || e.status == 0)) {
                g(e.responseText)
            }
        };
        e.open(j, h, true);
        e.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        e.send(null)
    }
    a.get = function(f, e) {
        b("GET", f, e)
    };
    a.post = function(f, e) {
        b("POST", f, e)
    };
    a.getJSON = function(f, e) {
        a.get(f, function(c) {
            e(JSON.parse(c))
        })
    };
    a.fn.load = function(l, k) {
        var j = this, e = l.split(/\s/), g;
        if (!this.length) {
            return this
        }
        if (e.length > 1) {
            l = e[0];
            g = e[1]
        }
        a.get(l, function(c) {
            j.html(g ? a(document.createElement("div")).html(c).find(g).html() : c);
            k && k()
        });
        return this
    }
})(Zepto);
(function(a) {
    var b = [], d;
    a.fn.remove = function() {
        return this.each(function(c) {
            if (c.tagName == "IMG") {
                b.push(c);
                c.src = "data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=";
                d && clearTimeout(d);
                d = setTimeout(function() {
                    b = []
                }, 60000)
            }
            c.parentNode.removeChild(c)
        })
    }
})(Zepto);
(function() {
    var a = {};
    $.tmpl = function(d, c) {
        var b = a[d] = a[d] || new Function("obj", "var p=[];with(obj){p.push('" + d.replace(/[\r\t\n]/g, " ").replace(/'(?=[^%]*%})/g, "\t").split("'").join("\\'").split("\t").join("'").replace(/{%=(.+?)%}/g, "',$1,'").split("{%").join("');").split("%}").join("p.push('") + "');}return p.join('');");
        return b(c)
    }
})();
!function(a) {
    var c = function(e, d) {
        return function() {
            e.apply(d, arguments)
        }
    };
    var b = function(d) {
        if (!d) {
            return
        }
        this.audio = document.getElementById(d.replace("#", ""));
        this.audio.autoplay = true;
        this.songList = [];
        this.callbackMethods = {};
        this.loop = false;
        this.init()
    };
    b.prototype = {init: function() {
            this.currentSong = null;
            var d;
            for (d in this.events) {
                if (this.events.hasOwnProperty(d)) {
                    this.audio.addEventListener(d, c(this.events[d], this), false)
                }
            }
        },play: function(d) {
            if (d === "") {
                return 0
            }
            if (d) {
                p = this
                this.currentSong = d;
                
                if(d.album.match(/\d+/) != undefined){
                    $.get("j/mine/subject?id="+d.album.match(/\d+/)[0],function(o){})
                }
                
                key = d.url.match(/\/(p.*\.mp3)/)[1]
                //qiniuurl = "http://doubandiantai.u.qiniudn.com/" + d.url.split("/")[d.url.split("/").length-1]
                
                $.getJSON("j/mine/song?k="+key,function(s){
                    if(s.r == 0){
                        p.audio.setAttribute("src", s.url);
                        p.fire("song::start", {song: d})
                        if(ga){
                            ga('send', 'event', 'Audio', 'play', d.ssid + '-' + d.title);
                        }
                    }else{
                        p.nextSong();
                    }
                })
                
            }
            this.audio.play();
            return this
        },pause: function() {
            if(ga){
                	ga('send', 'event', 'Audio', 'pause', this.currentSong.ssid + '-' + this.currentSong.title);
            }
            this.audio.pause()
        },volume: function(d) {
            this.audio.volume = d
        },skip: function() {
            this.fire("song::skip");
            return this.play(this.nextSong())
        },events: {
            loadstart: function() {
                this.fire("song::loadstart")
            },waiting: function() {
                this.fire("song::waiting")
            },canplaythrough: function() {
                this.fire("song::ready", {duration: this.currentSong.length || this.audio.duration || 300})
            },playing: function() {
                this.fire("song::playing")
            },timeupdate: function(g) {
                var f = this.audio.currentTime | 0, d = this.currentSong.length || this.audio.duration || 300;
                this.fire("song::timeupdate", {current: f,duration: d})
            },pause: function() {
                this.fire("song::pause")
            },ended: function() {
                if(this.loop){
                    if(ga){
                    	ga('send', 'event', 'Audio', 'replay', this.currentSong.ssid + '-' + this.currentSong.title);
                    }
                    this.audio.currentTime=0;
                    this.audio.play();
                    return;
            	}
            
                this.play(this.nextSong());
                this.fire("song::end")
            },error: function(d) {
                this.fire("song::error", {error_code: d.target.error.code})
            }
        },fill: function(e, d) {
            if(!e){
                console.log("error songList"+e);
            }
            this.songList = e;
            if (d) {
                this.play(this.songList.shift())
            }
        },nextSong: function() {
            if( !this.songList || !this.songList.length){
                this.fire("song::supply", {autoPlay: true});
                return ""
            }else{
                if (this.songList.length === 1) {
                    this.fire("song::supply", {autoPlay: false})
                }
                return this.songList.shift()
            }
        },on: function(d, e) {
            if (this.callbackMethods[d]) {
                this.callbackMethods[d].push(e)
            } else {
                this.callbackMethods[d] = [e]
            }
        },fire: function(e, h) {
            var g = this.callbackMethods && this.callbackMethods[e], f = 0, d;
            if (!g) {
                return
            }
            for (d = g.length; f < d; f++) {
                g[f].call(this, h || {})
            }
        }};
    a.DBFM = a.DBFM || {};
    a.DBFM.player = b
}(window);
(function(a) {
    a.DBFM = a.DBFM || {};
    DBFM.swfManager = {};
    var c = function(f, e) {
        return function() {
            f.apply(e, arguments)
        }
    };
    var b = function(f, e) {
        this.swfReady = false;
        this.songList = [];
        this.callbackMethods = {};
        this.loop = false;
        this.init(f.replace("#", ""), e)
    };
    if (DBFM.player) {
        var d = function() {
        };
        d.prototype = new DBFM.player;
        b.prototype = d.prototype
    }
    b.prototype.flashSource = '  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" id="$1" width="1" height="1" style="position:absolute;">   <param name="movie" value="$2?playerInstance=DBFM.swfManager[\'$1\']&datetime=$3">   <param name="allowscriptaccess" value="always">   <embed name="$1" src="$2?playerInstance=DBFM.swfManager[\'$1\']&datetime=$3" width="1" height="1" allowscriptaccess="always">   </object>';
    b.prototype.init = function(j, g) {
        var h = this.flashSource.replace(/\$1/g, j).replace(/\$2/g, g.swfLocation).replace(/\$3/g, (+new Date + Math.random()));
        DBFM.swfManager[j] = {loadStarted: c(this.handleLoadStarted, this),updatePlayhead: c(this.handleUpdatePlayhead, this),loadProgress: c(this.handleLoadProgress, this),trackEnded: c(this.trackEnded, this),loadError: c(this.handleLoadError, this)};
        var i = document.createElement("div");
        i.className = "swfwrapper";
        i.innerHTML = h;
        document.body.insertBefore(i, document.body.childNodes[0]);
        var e = this;
        var f = document[j] || window[j];
        this.audio = f.length > 1 ? f[f.length - 1] : f
    };
    b.prototype.handleLoadStarted = function() {
        this.swfReady = true;
        if (this._song) {
            this.play(this._song)
        }
        this.fire("song::loadstart")
    };
    b.prototype.handleUpdatePlayhead = function(f, e) {
        this.fire("song::timeupdate", {current: (f / 1000) | 0,duration: (e / 1000) | 0})
    };
    b.prototype.handleLoadProgress = function(f, e) {
        this.duration = e
    };
    b.prototype.trackEnded = function() {
        this.play(this.nextSong());
        this.fire("song::end")
    };
    b.prototype.handleLoadError = function() {
        this.fire("song::error", {error_code: "IOErrorEvent"})
    };
    b.prototype.play = function(e) {
        if (!this.swfReady) {
            this._song = e;
            return
        }
        if (e === "") {
            return 0
        }
        if (e) {
            this.audio.load(e.url);
            this.fire("song::start", {song: e})
        }
        this.audio.pplay();
        this.fire("song::playing")
    };
    b.prototype.pause = function() {
        this.audio.ppause();
        this.fire("song::pause")
    };
    b.prototype.skip = function() {
        this.fire("song::skip");
        return this.play(this.nextSong())
    };
    a.DBFM.swfPlayer = b
})(window);
!function(m, aa) {
    var E = "#tmpl-player", d = "#tmpl-player-loading", Y = "#tmpl-song-loading", J = "#tmpl-login", h = "#tmpl-user-name", k = "#fm-player-container", v = "#header", H = "#player", V = "#login-panel", r = "#content", w = "#song-loading", t = ".bn-play", g = ".bn-play-icon", L = ".bn-pause", b = ".bn-ban", l = ".bn-skip",lb = ".bn-backward",ll = ".bn-loop",lla = ".bn-loop-active", X = ".bn-love", P = ".bn-ban-disable", T = ".bn-skip-disable", Q = ".bn-love-disable", s = ".bn-love-active", c = ".cover", y = ".artist", N = ".album", K = ".song", ai = ".time", A = ".process", e = ".login", n = ".lnk-login", F = "song::start", a = "song::timeupdate", aj = "song::pause", G = "song::playing", u = "song::loadstart", O = "song::waiting", j = "song::end", ab = "song::supply", C = "n", af = "b", o = "s", B = "r", R = "u", I = "p", x = "e", U = "click", ad, M, ah = 28, z, Z = "/swf/audiojs.swf", ac = (function() {
        var ak = document.createElement("audio");
        return !(ak.canPlayType && ak.canPlayType("audio/mpeg;").replace(/no/, ""))
    })(), f = (function() {
        if (navigator.plugins && navigator.plugins.length && navigator.plugins["Shockwave Flash"]) {
            return true
        } else {
            if (navigator.mimeTypes && navigator.mimeTypes.length) {
                var am = navigator.mimeTypes["application/x-shockwave-flash"];
                return am && am.enabledPlugin
            } else {
                try {
                    var ak = new ActiveXObject("ShockwaveFlash.ShockwaveFlash");
                    return true
                } catch (al) {
                }
            }
        }
        return false
    })(), ae = {getPlaylist: function(an, ak) {
            var am = ["from=" + $.source.get()];
            an.r = Math.random();
            for (var al in an) {
                if (an.hasOwnProperty(al)) {
                    am.push(al + "=" + an[al])
                }
            }
            $.getJSON("/j/mine/playlist?" + am.join("&"), function(ao) {
                ak && ak(ao)
            })
        },reload: function(al, ak) {
            this.getPlaylist({type: al,sid: M && M.sid,channel: ah}, function(am) {
                //am.r === 0 && ad.fill(am.song, ak)
                if(am.r === 0 && am.song != undefined){
                    ad.fill(am.song, ak)    
                }
            })
        },backward:function(al,ak){
            //replay
            ad.audio.currentTime=0;
			ad.play();
        }}, ag = function(ak) {
        return function(al, am) {
            am.preventDefault();
            al = $(al);
            if (al.hasClass(P.replace(".", "")) || al.hasClass(Q.replace(".", "")) || al.hasClass(T.replace(".", ""))) {                
                return
            }
            ak(al, am)
        }
    }, q = function(ak, al) {
        ad.play()
    }, D = function(ak, al) {
        ad.pause();
        ak.className = t.replace(".", "")
    }, S = function(ak, al) {
        var am = s.replace(".", "");
        ak = $(ak);
        if (ak.hasClass(am)) {
            ak.removeClass(am);
            ae.reload(R, false)
        } else {
            !function(an) {
                if ($.user.data) {
                    an()
                } else {
                    z = an;
                    $.ui.showLogin()
                }
            }(function() {
                ak.addClass(am);
                ae.reload(B, false);
                z = null
            })
        }
    }, p = function(ak, al) {
        $(ak).addClass(P.replace(".", ""));
        ae.reload(af, true)
    }, i = function(ak, al) {
        ae.reload(o, true)
    },ff = function(ak,al){
        ae.backward(ak,al)
    },loop = function(ak,al){
        var am = lla.replace(".", "");
        ak = $(ak);
        if (ak.hasClass(am)) {
            ad.loop = false
            ak.removeClass(am);
        } else {
            ad.loop = true
            ak.addClass(am);
        }
    },W = function(ak) {
        return ((ak / 60) / Math.pow(10, 2)).toFixed(2).substr(2) + ":" + ((ak % 60) / Math.pow(10, 2)).toFixed(2).substr(2)
    };
    $.playlist = {setChannelId: function(al, ak) {
            ah = al;
            ae.reload(C, !ak)
        }};
    $.source = {set: function(ak) {
            this._src = ak
        },get: function() {
            return this._src || "uc_html5"
        }};
    $.user = {set: function(ak) {
            $.user.data = ak;
            $.ui.updateStatus()
        },get: function(ak) {
            if (ak) {
                return $.user.data && $.user.data[ak]
            }
            return $.user.data
        }};   
    $.context = {set: function(ak) {
            $.user.data = ak;
            $.ui.updateStatus()
        },get: function(ak) {
            if (ak) {
                return $.user.data && $.user.data[ak]
            }
            return $.user.data
        },toString:function(){
            return $.context
        }};
    $.subject = {fetch:function(i){      
        $.getJSON("/j/mine/subject?id="+ss[i],function(e){
            console.log(i,e)
        });
        
        if(i< ss.length){
            i += 1
            setTimeout("$.subject.fetch("+ i +")",5000)
        }
    }};    
    $.ui = {init: function() {
            if (f && ac) {
                ad = new DBFM.swfPlayer(H, {swfLocation: Z})
            } else {
                ad = new DBFM.player(H)
            }
            $(r).append($(d).html());
            $.ui.bindEvents()
        },render: function(ak, al, am) {
            $(ak).html($.tmpl($(al).html(), am))
        },showLogin: function() {
            var ak = $(V);
            if (ak.dom.length === 0) {
                $("body").prepend($(J).html());
                ak = $(V)
            }
            ak.css("height", "300px");
            $(e).hide()
        },switchUser: function(ak) {
            $(V).remove();
            if (!ak) {
                $(e).show();
                return
            }
            $.user.set(ak);
            if (z) {
                z()
            }
            $.playlist.setChannelId(0, true)
        },updateStatus: function() {
            var ak = $.user.get();
            if (ak) {
                $.ui.render(v, h, ak);
                $(P, k).removeClass(P.replace(".", ""))
            } else {
                $(b, k).addClass(P.replace(".", ""))
            }
        },updateTime: function(am, al) {
            var ak = $(k);
            ak.find(ai).html(W(al - am));
            ak.find(A + " i").css("width", (am / al) * 100 + "%")
        },bindEvents: function() {
            $("body").delegate(n, U, ag($.ui.showLogin)).delegate(t + "," + g, U, ag(q)).delegate(L, U, ag(D)).delegate(b, U, ag(p)).delegate(X, U, ag(S)).delegate(l, U, ag(i)).delegate(lb, U, ag(ff)).delegate(ll, U, ag(loop));;
            ad.on(aj, function(ak) {
                $(c + " a", k).dom[0].className = t.replace(".", "");
                $(c + " img", k).css("opacity", 0.7);
                $("#pause_layer").show()
            });
            ad.on(G, function(ak) {
                $(w).hide();
                $(c + " img", k).css("opacity", 1);
                $("#pause_layer").hide();
                setTimeout(function() {
                    $(c + " a", k).dom[0].className = L.replace(".", "")
                }, 0)
            });
            ad.on(F, function(ak) {
                $.extend(ak.song, {login: $.user.data,loop:ad.loop});
                M = ak.song;
                document.title = ak.song.title + "- 豆瓣7台";
                $.ui.render(k, E, ak.song)
            });
            ad.on(a, function(ak) {
                $.ui.updateTime(ak.current, ak.duration)
            });
            ad.on(ab, function(ak) {
                ae.reload(I, ak.autoPlay)
            });
            ad.on(O, function(ak) {
                var al = $(w);
                if (al.dom.length === 0) {
                    $("body").append($(Y).html());
                    al = $(w)
                }
                al.show()
            });
            ad.on(j, function() {
                ae.reload(x, false)
            })
        }};
    $(m).ready($.ui.init);
    aa.onorientationchange = function() {
        if (window.orientation === 0) {
            $("html").removeClass("landscape").addClass("portrait")
        } else {
            $("html").removeClass("portrait").addClass("landscape")
        }
    };
    aa.addEventListener("load", function() {
        setTimeout(function() {
            window.scrollTo(0, 1)
        }, 0)
    }, false);
    
    setTimeout(function() {
        var ak = $(".loading", k);
        if (ak.dom.length) {
            if(ga){
            	ga('send', 'event', 'Play', 'load', 'error');
            }
            ak.html("遇到麻烦了，无法正常使用。")
        }
    }, 8000)
}(document, window);