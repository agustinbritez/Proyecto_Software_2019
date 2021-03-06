/* interact.js 1.6.3 | https://raw.github.com/taye/interact.js/master/LICENSE */ ! function (e) {
    if ("object" == typeof exports && "undefined" != typeof module) module.exports = e();
    else if ("function" == typeof define && define.amd) define([], e);
    else {
        ("undefined" != typeof window ? window : "undefined" != typeof global ? global : "undefined" != typeof self ? self : this).interact = e()
    }
}(function () {
    function e(t) {
        var n;
        return function (e) {
            return n || t(n = {
                exports: {},
                parent: e
            }, n.exports), n.exports
        }
    }
    var h = e(function (e, t) {
            "use strict";
            Object.defineProperty(t, "__esModule", {
                value: !0
            }), t.Scope = t.ActionName = void 0;
            var o = function (e) {
                    if (e && e.__esModule) return e;
                    var t = f();
                    if (t && t.has(e)) return t.get(e);
                    var n = {};
                    if (null != e) {
                        var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
                        for (var o in e)
                            if (Object.prototype.hasOwnProperty.call(e, o)) {
                                var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                                i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                            }
                    }
                    n.default = e, t && t.set(e, n);
                    return n
                }(lt),
                n = c(k),
                i = c(kt),
                a = c(It),
                s = c(Ft),
                u = c(nn),
                l = c(wn),
                r = c(S({}));

            function c(e) {
                return e && e.__esModule ? e : {
                    default: e
                }
            }

            function f() {
                if ("function" != typeof WeakMap) return null;
                var e = new WeakMap;
                return f = function () {
                    return e
                }, e
            }

            function p(e) {
                return (p = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
                    return typeof e
                } : function (e) {
                    return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
                })(e)
            }

            function d(e, t) {
                return !t || "object" !== p(t) && "function" != typeof t ? function (e) {
                    if (void 0 !== e) return e;
                    throw new ReferenceError("this hasn't been initialised - super() hasn't been called")
                }(e) : t
            }

            function v(e, t, n) {
                return (v = "undefined" != typeof Reflect && Reflect.get ? Reflect.get : function (e, t, n) {
                    var r = function (e, t) {
                        for (; !Object.prototype.hasOwnProperty.call(e, t) && null !== (e = g(e)););
                        return e
                    }(e, t);
                    if (r) {
                        var o = Object.getOwnPropertyDescriptor(r, t);
                        return o.get ? o.get.call(n) : o.value
                    }
                })(e, t, n || e)
            }

            function g(e) {
                return (g = Object.setPrototypeOf ? Object.getPrototypeOf : function (e) {
                    return e.__proto__ || Object.getPrototypeOf(e)
                })(e)
            }

            function h(e, t) {
                return (h = Object.setPrototypeOf || function (e, t) {
                    return e.__proto__ = t, e
                })(e, t)
            }

            function y(e, t) {
                if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
            }

            function m(e, t) {
                for (var n = 0; n < t.length; n++) {
                    var r = t[n];
                    r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
                }
            }

            function b(e, t, n) {
                return t && m(e.prototype, t), n && m(e, n), e
            }
            var w, O = o.win,
                P = o.browser,
                _ = o.raf,
                x = o.Signals,
                j = o.events;
            (t.ActionName = w) || (t.ActionName = w = {});
            var M = function () {
                function e() {
                    var t = this;
                    y(this, e), this.id = "__interact_scope_".concat(Math.floor(100 * Math.random())), this.signals = new x, this.browser = P, this.events = j, this.utils = o, this.defaults = o.clone(i.default), this.Eventable = a.default, this.actions = {
                        names: [],
                        methodDict: {},
                        eventTypes: []
                    }, this.InteractEvent = l.default, this.interactables = new u.default(this), this.documents = [], this._plugins = [], this._pluginMap = {}, this.onWindowUnload = function (e) {
                        return t.removeDocument(e.target)
                    };
                    var r = this;
                    this.Interactable = function () {
                        function n() {
                            return y(this, n), d(this, g(n).apply(this, arguments))
                        }
                        return function (e, t) {
                            if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function");
                            e.prototype = Object.create(t && t.prototype, {
                                constructor: {
                                    value: e,
                                    writable: !0,
                                    configurable: !0
                                }
                            }), t && h(e, t)
                        }(n, s["default"]), b(n, [{
                            key: "set",
                            value: function (e) {
                                return v(g(n.prototype), "set", this).call(this, e), r.interactables.signals.fire("set", {
                                    options: e,
                                    interactable: this
                                }), this
                            }
                        }, {
                            key: "unset",
                            value: function () {
                                v(g(n.prototype), "unset", this).call(this);
                                for (var e = r.interactions.list.length - 1; 0 <= e; e--) {
                                    var t = r.interactions.list[e];
                                    t.interactable === this && (t.stop(), r.interactions.signals.fire("destroy", {
                                        interaction: t
                                    }), t.destroy(), 2 < r.interactions.list.length && r.interactions.list.splice(e, 1))
                                }
                                r.interactables.signals.fire("unset", {
                                    interactable: this
                                })
                            }
                        }, {
                            key: "_defaults",
                            get: function () {
                                return r.defaults
                            }
                        }]), n
                    }()
                }
                return b(e, [{
                    key: "init",
                    value: function (e) {
                        return E(this, e)
                    }
                }, {
                    key: "pluginIsInstalled",
                    value: function (e) {
                        return this._pluginMap[e.id] || -1 !== this._plugins.indexOf(e)
                    }
                }, {
                    key: "usePlugin",
                    value: function (e, t) {
                        return this.pluginIsInstalled(e) || (e.id && (this._pluginMap[e.id] = e), e.install(this, t), this._plugins.push(e)), this
                    }
                }, {
                    key: "addDocument",
                    value: function (e, t) {
                        if (-1 !== this.getDocIndex(e)) return !1;
                        var n = O.getWindow(e);
                        t = t ? o.extend({}, t) : {}, this.documents.push({
                            doc: e,
                            options: t
                        }), j.documents.push(e), e !== this.document && j.add(n, "unload", this.onWindowUnload), this.signals.fire("add-document", {
                            doc: e,
                            window: n,
                            scope: this,
                            options: t
                        })
                    }
                }, {
                    key: "removeDocument",
                    value: function (e) {
                        var t = this.getDocIndex(e),
                            n = O.getWindow(e),
                            r = this.documents[t].options;
                        j.remove(n, "unload", this.onWindowUnload), this.documents.splice(t, 1), j.documents.splice(t, 1), this.signals.fire("remove-document", {
                            doc: e,
                            window: n,
                            scope: this,
                            options: r
                        })
                    }
                }, {
                    key: "getDocIndex",
                    value: function (e) {
                        for (var t = 0; t < this.documents.length; t++)
                            if (this.documents[t].doc === e) return t;
                        return -1
                    }
                }, {
                    key: "getDocOptions",
                    value: function (e) {
                        var t = this.getDocIndex(e);
                        return -1 === t ? null : this.documents[t].options
                    }
                }, {
                    key: "now",
                    value: function () {
                        return (this.window.Date || Date).now()
                    }
                }]), e
            }();

            function E(e, t) {
                return O.init(t), n.default.init(t), P.init(t), _.init(t), j.init(t), e.usePlugin(r.default), e.document = t.document, e.window = t, e
            }
            t.Scope = M
        }),
        S = e(function (e, t) {
            "use strict";
            Object.defineProperty(t, "__esModule", {
                value: !0
            }), t.default = void 0;
            var P = n(M),
                u = n(k),
                f = n(de),
                _ = n(ne),
                l = n(at),
                c = n(a({})),
                o = n(Yn);

            function n(e) {
                return e && e.__esModule ? e : {
                    default: e
                }
            }

            function r(e) {
                return (r = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
                    return typeof e
                } : function (e) {
                    return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
                })(e)
            }

            function x(e, t) {
                return function (e) {
                    if (Array.isArray(e)) return e
                }(e) || function (e, t) {
                    if (!(Symbol.iterator in Object(e) || "[object Arguments]" === Object.prototype.toString.call(e))) return;
                    var n = [],
                        r = !0,
                        o = !1,
                        i = void 0;
                    try {
                        for (var a, s = e[Symbol.iterator](); !(r = (a = s.next()).done) && (n.push(a.value), !t || n.length !== t); r = !0);
                    } catch (e) {
                        o = !0, i = e
                    } finally {
                        try {
                            r || null == s.return || s.return()
                        } finally {
                            if (o) throw i
                        }
                    }
                    return n
                }(e, t) || function () {
                    throw new TypeError("Invalid attempt to destructure non-iterable instance")
                }()
            }

            function p(e, t) {
                for (var n = 0; n < t.length; n++) {
                    var r = t[n];
                    r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
                }
            }

            function d(e, t) {
                return !t || "object" !== r(t) && "function" != typeof t ? function (e) {
                    if (void 0 !== e) return e;
                    throw new ReferenceError("this hasn't been initialised - super() hasn't been called")
                }(e) : t
            }

            function v(e) {
                return (v = Object.setPrototypeOf ? Object.getPrototypeOf : function (e) {
                    return e.__proto__ || Object.getPrototypeOf(e)
                })(e)
            }

            function g(e, t) {
                return (g = Object.setPrototypeOf || function (e, t) {
                    return e.__proto__ = t, e
                })(e, t)
            }
            var h = ["pointerDown", "pointerMove", "pointerUp", "updatePointer", "removePointer", "windowBlur"];

            function y(w, O) {
                return function (e) {
                    var t = O.interactions.list,
                        n = _.default.getPointerType(e),
                        r = x(_.default.getEventTargets(e), 2),
                        o = r[0],
                        i = r[1],
                        a = [];
                    if (/^touch/.test(e.type)) {
                        O.prevTouchTime = O.now();
                        for (var s = 0; s < e.changedTouches.length; s++) {
                            var u = e.changedTouches[s],
                                l = {
                                    pointer: u,
                                    pointerId: _.default.getPointerId(u),
                                    pointerType: n,
                                    eventType: e.type,
                                    eventTarget: o,
                                    curEventTarget: i,
                                    scope: O
                                },
                                c = j(l);
                            a.push([l.pointer, l.eventTarget, l.curEventTarget, c])
                        }
                    } else {
                        var f = !1;
                        if (!P.default.supportsPointerEvent && /mouse/.test(e.type)) {
                            for (var p = 0; p < t.length && !f; p++) f = "mouse" !== t[p].pointerType && t[p].pointerIsDown;
                            f = f || O.now() - O.prevTouchTime < 500 || 0 === e.timeStamp
                        }
                        if (!f) {
                            var d = {
                                    pointer: e,
                                    pointerId: _.default.getPointerId(e),
                                    pointerType: n,
                                    eventType: e.type,
                                    curEventTarget: i,
                                    eventTarget: o,
                                    scope: O
                                },
                                v = j(d);
                            a.push([d.pointer, d.eventTarget, d.curEventTarget, v])
                        }
                    }
                    for (var g = 0; g < a.length; g++) {
                        var h = x(a[g], 4),
                            y = h[0],
                            m = h[1],
                            b = h[2];
                        h[3][w](y, e, m, b)
                    }
                }
            }

            function j(e) {
                var t = e.pointerType,
                    n = e.scope,
                    r = {
                        interaction: o.default.search(e),
                        searchDetails: e
                    };
                return n.interactions.signals.fire("find", r), r.interaction || n.interactions.new({
                    pointerType: t
                })
            }

            function m(e, t) {
                var n = e.doc,
                    r = e.scope,
                    o = e.options,
                    i = r.interactions.docEvents,
                    a = 0 === t.indexOf("add") ? f.default.add : f.default.remove;
                for (var s in r.browser.isIOS && !o.events && (o.events = {
                        passive: !1
                    }), f.default.delegatedEvents) a(n, s, f.default.delegateListener), a(n, s, f.default.delegateUseCapture, !0);
                for (var u = o && o.events, l = 0; l < i.length; l++) {
                    var c = i[l];
                    a(n, c.type, c.listener, u)
                }
            }
            var i = {
                id: "core/interactions",
                install: function (o) {
                    for (var n = new l.default, e = {}, t = 0; t < h.length; t++) {
                        var r = h[t];
                        e[r] = y(r, o)
                    }
                    var i, a = P.default.pEventTypes;

                    function s() {
                        for (var e = 0; e < o.interactions.list.length; e++) {
                            var t = o.interactions.list[e];
                            if (t.pointerIsDown && "touch" === t.pointerType && !t._interacting)
                                for (var n = function () {
                                        var n = t.pointers[r];
                                        o.documents.some(function (e) {
                                            var t = e.doc;
                                            return (0, A.nodeContains)(t, n.downTarget)
                                        }) || t.removePointer(n.pointer, n.event)
                                    }, r = 0; r < t.pointers.length; r++) {
                                    n()
                                }
                        }
                    }(i = u.default.PointerEvent ? [{
                        type: a.down,
                        listener: s
                    }, {
                        type: a.down,
                        listener: e.pointerDown
                    }, {
                        type: a.move,
                        listener: e.pointerMove
                    }, {
                        type: a.up,
                        listener: e.pointerUp
                    }, {
                        type: a.cancel,
                        listener: e.pointerUp
                    }] : [{
                        type: "mousedown",
                        listener: e.pointerDown
                    }, {
                        type: "mousemove",
                        listener: e.pointerMove
                    }, {
                        type: "mouseup",
                        listener: e.pointerUp
                    }, {
                        type: "touchstart",
                        listener: s
                    }, {
                        type: "touchstart",
                        listener: e.pointerDown
                    }, {
                        type: "touchmove",
                        listener: e.pointerMove
                    }, {
                        type: "touchend",
                        listener: e.pointerUp
                    }, {
                        type: "touchcancel",
                        listener: e.pointerUp
                    }]).push({
                        type: "blur",
                        listener: function (e) {
                            for (var t = 0; t < o.interactions.list.length; t++) {
                                o.interactions.list[t].documentBlur(e)
                            }
                        }
                    }), o.signals.on("add-document", m), o.signals.on("remove-document", m), o.prevTouchTime = 0, o.Interaction = function () {
                        function e() {
                            return function (e, t) {
                                if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
                            }(this, e), d(this, v(e).apply(this, arguments))
                        }
                        return function (e, t) {
                                if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function");
                                e.prototype = Object.create(t && t.prototype, {
                                    constructor: {
                                        value: e,
                                        writable: !0,
                                        configurable: !0
                                    }
                                }), t && g(e, t)
                            }(e, c["default"]),
                            function (e, t, n) {
                                t && p(e.prototype, t), n && p(e, n)
                            }(e, [{
                                key: "_now",
                                value: function () {
                                    return o.now()
                                }
                            }, {
                                key: "pointerMoveTolerance",
                                get: function () {
                                    return o.interactions.pointerMoveTolerance
                                },
                                set: function (e) {
                                    o.interactions.pointerMoveTolerance = e
                                }
                            }]), e
                    }(), o.interactions = {
                        signals: n,
                        list: [],
                        new: function (e) {
                            e.signals = n;
                            var t = new o.Interaction(e);
                            return o.interactions.list.push(t), t
                        },
                        listeners: e,
                        docEvents: i,
                        pointerMoveTolerance: 1
                    }
                },
                onDocSignal: m,
                doOnInteractions: y,
                methodNames: h
            };
            t.default = i
        }),
        a = e(function (e, t) {
            "use strict";
            Object.defineProperty(t, "__esModule", {
                value: !0
            }), Object.defineProperty(t, "PointerInfo", {
                enumerable: !0,
                get: function () {
                    return s.default
                }
            }), t.default = t.Interaction = t._ProxyMethods = t._ProxyValues = void 0;
            var n, c, r, f, o, p = l(lt),
                i = l(wn),
                s = (n = Rn) && n.__esModule ? n : {
                    default: n
                },
                a = h({});

            function u() {
                if ("function" != typeof WeakMap) return null;
                var e = new WeakMap;
                return u = function () {
                    return e
                }, e
            }

            function l(e) {
                if (e && e.__esModule) return e;
                var t = u();
                if (t && t.has(e)) return t.get(e);
                var n = {};
                if (null != e) {
                    var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
                    for (var o in e)
                        if (Object.prototype.hasOwnProperty.call(e, o)) {
                            var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                            i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                        }
                }
                return n.default = e, t && t.set(e, n), n
            }

            function d(e, t) {
                for (var n = 0; n < t.length; n++) {
                    var r = t[n];
                    r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
                }
            }
            t._ProxyValues = c, (r = c || (t._ProxyValues = c = {})).interactable = "", r.element = "", r.prepared = "", r.pointerIsDown = "", r.pointerWasMoved = "", r._proxy = "", t._ProxyMethods = f, (o = f || (t._ProxyMethods = f = {})).start = "", o.move = "", o.end = "", o.stop = "", o.interacting = "";
            var v = function () {
                    function l(e) {
                        var t = this,
                            n = e.pointerType,
                            r = e.signals;
                        ! function (e, t) {
                            if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
                        }(this, l), this.interactable = null, this.element = null, this.prepared = {
                            name: null,
                            axis: null,
                            edges: null
                        }, this.pointers = [], this.downEvent = null, this.downPointer = {}, this._latestPointer = {
                            pointer: null,
                            event: null,
                            eventTarget: null
                        }, this.prevEvent = null, this.pointerIsDown = !1, this.pointerWasMoved = !1, this._interacting = !1, this._ending = !1, this._stopped = !0, this._proxy = null, this.simulation = null, this.doMove = p.warnOnce(function (e) {
                            this.move(e)
                        }, "The interaction.doMove() method has been renamed to interaction.move()"), this.coords = {
                            start: p.pointer.newCoords(),
                            prev: p.pointer.newCoords(),
                            cur: p.pointer.newCoords(),
                            delta: p.pointer.newCoords(),
                            velocity: p.pointer.newCoords()
                        }, this._signals = r, this.pointerType = n;
                        var o = this;
                        this._proxy = {};

                        function i(e) {
                            Object.defineProperty(t._proxy, e, {
                                get: function () {
                                    return o[e]
                                }
                            })
                        }
                        for (var a in c) i(a);

                        function s(e) {
                            Object.defineProperty(t._proxy, e, {
                                value: function () {
                                    return o[e].apply(o, arguments)
                                }
                            })
                        }
                        for (var u in f) s(u);
                        this._signals.fire("new", {
                            interaction: this
                        })
                    }
                    return function (e, t, n) {
                        t && d(e.prototype, t), n && d(e, n)
                    }(l, [{
                        key: "pointerDown",
                        value: function (e, t, n) {
                            var r = this.updatePointer(e, t, n, !0);
                            this._signals.fire("down", {
                                pointer: e,
                                event: t,
                                eventTarget: n,
                                pointerIndex: r,
                                interaction: this
                            })
                        }
                    }, {
                        key: "start",
                        value: function (e, t, n) {
                            return !(this.interacting() || !this.pointerIsDown || this.pointers.length < (e.name === a.ActionName.Gesture ? 2 : 1) || !t.options[e.name].enabled) && (p.copyAction(this.prepared, e), this.interactable = t, this.element = n, this.rect = t.getRect(n), this.edges = this.prepared.edges, this._stopped = !1, this._interacting = this._doPhase({
                                interaction: this,
                                event: this.downEvent,
                                phase: i.EventPhase.Start
                            }) && !this._stopped, this._interacting)
                        }
                    }, {
                        key: "pointerMove",
                        value: function (e, t, n) {
                            this.simulation || this.modifiers && this.modifiers.endPrevented || (this.updatePointer(e, t, n, !1), p.pointer.setCoords(this.coords.cur, this.pointers.map(function (e) {
                                return e.pointer
                            }), this._now()));
                            var r, o, i = this.coords.cur.page.x === this.coords.prev.page.x && this.coords.cur.page.y === this.coords.prev.page.y && this.coords.cur.client.x === this.coords.prev.client.x && this.coords.cur.client.y === this.coords.prev.client.y;
                            this.pointerIsDown && !this.pointerWasMoved && (r = this.coords.cur.client.x - this.coords.start.client.x, o = this.coords.cur.client.y - this.coords.start.client.y, this.pointerWasMoved = p.hypot(r, o) > this.pointerMoveTolerance);
                            var a = {
                                pointer: e,
                                pointerIndex: this.getPointerIndex(e),
                                event: t,
                                eventTarget: n,
                                dx: r,
                                dy: o,
                                duplicate: i,
                                interaction: this
                            };
                            i || (p.pointer.setCoordDeltas(this.coords.delta, this.coords.prev, this.coords.cur), p.pointer.setCoordVelocity(this.coords.velocity, this.coords.delta)), this._signals.fire("move", a), i || (this.interacting() && this.move(a), this.pointerWasMoved && p.pointer.copyCoords(this.coords.prev, this.coords.cur))
                        }
                    }, {
                        key: "move",
                        value: function (e) {
                            (e = p.extend({
                                pointer: this._latestPointer.pointer,
                                event: this._latestPointer.event,
                                eventTarget: this._latestPointer.eventTarget,
                                interaction: this
                            }, e || {})).phase = i.EventPhase.Move, this._doPhase(e)
                        }
                    }, {
                        key: "pointerUp",
                        value: function (e, t, n, r) {
                            var o = this.getPointerIndex(e); - 1 === o && (o = this.updatePointer(e, t, n, !1)), this._signals.fire(/cancel$/i.test(t.type) ? "cancel" : "up", {
                                pointer: e,
                                pointerIndex: o,
                                event: t,
                                eventTarget: n,
                                curEventTarget: r,
                                interaction: this
                            }), this.simulation || this.end(t), this.pointerIsDown = !1, this.removePointer(e, t)
                        }
                    }, {
                        key: "documentBlur",
                        value: function (e) {
                            this.end(e), this._signals.fire("blur", {
                                event: e,
                                interaction: this
                            })
                        }
                    }, {
                        key: "end",
                        value: function (e) {
                            var t;
                            this._ending = !0, e = e || this._latestPointer.event, this.interacting() && (t = this._doPhase({
                                event: e,
                                interaction: this,
                                phase: i.EventPhase.End
                            })), !(this._ending = !1) === t && this.stop()
                        }
                    }, {
                        key: "currentAction",
                        value: function () {
                            return this._interacting ? this.prepared.name : null
                        }
                    }, {
                        key: "interacting",
                        value: function () {
                            return this._interacting
                        }
                    }, {
                        key: "stop",
                        value: function () {
                            this._signals.fire("stop", {
                                interaction: this
                            }), this.interactable = this.element = null, this._interacting = !1, this._stopped = !0, this.prepared.name = this.prevEvent = null
                        }
                    }, {
                        key: "getPointerIndex",
                        value: function (e) {
                            var t = p.pointer.getPointerId(e);
                            return "mouse" === this.pointerType || "pen" === this.pointerType ? this.pointers.length - 1 : p.arr.findIndex(this.pointers, function (e) {
                                return e.id === t
                            })
                        }
                    }, {
                        key: "getPointerInfo",
                        value: function (e) {
                            return this.pointers[this.getPointerIndex(e)]
                        }
                    }, {
                        key: "updatePointer",
                        value: function (e, t, n, r) {
                            var o = p.pointer.getPointerId(e),
                                i = this.getPointerIndex(e),
                                a = this.pointers[i];
                            return r = !1 !== r && (r || /(down|start)$/i.test(t.type)), a ? a.pointer = e : (a = new s.default(o, e, t, null, null), i = this.pointers.length, this.pointers.push(a)), r && (this.pointerIsDown = !0, this.interacting() || (p.pointer.setCoords(this.coords.start, this.pointers.map(function (e) {
                                return e.pointer
                            }), this._now()), p.pointer.copyCoords(this.coords.cur, this.coords.start), p.pointer.copyCoords(this.coords.prev, this.coords.start), p.pointer.pointerExtend(this.downPointer, e), this.downEvent = t, a.downTime = this.coords.cur.timeStamp, a.downTarget = n, this.pointerWasMoved = !1)), this._updateLatestPointer(e, t, n), this._signals.fire("update-pointer", {
                                pointer: e,
                                event: t,
                                eventTarget: n,
                                down: r,
                                pointerInfo: a,
                                pointerIndex: i,
                                interaction: this
                            }), i
                        }
                    }, {
                        key: "removePointer",
                        value: function (e, t) {
                            var n = this.getPointerIndex(e);
                            if (-1 !== n) {
                                var r = this.pointers[n];
                                this._signals.fire("remove-pointer", {
                                    pointer: e,
                                    event: t,
                                    pointerIndex: n,
                                    pointerInfo: r,
                                    interaction: this
                                }), this.pointers.splice(n, 1)
                            }
                        }
                    }, {
                        key: "_updateLatestPointer",
                        value: function (e, t, n) {
                            this._latestPointer.pointer = e, this._latestPointer.event = t, this._latestPointer.eventTarget = n
                        }
                    }, {
                        key: "destroy",
                        value: function () {
                            this._latestPointer.pointer = null, this._latestPointer.event = null, this._latestPointer.eventTarget = null
                        }
                    }, {
                        key: "_createPreparedEvent",
                        value: function (e, t, n, r) {
                            var o = this.prepared.name;
                            return new i.default(this, e, o, t, this.element, null, n, r)
                        }
                    }, {
                        key: "_fireEvent",
                        value: function (e) {
                            this.interactable.fire(e), (!this.prevEvent || e.timeStamp >= this.prevEvent.timeStamp) && (this.prevEvent = e)
                        }
                    }, {
                        key: "_doPhase",
                        value: function (e) {
                            var t = e.event,
                                n = e.phase,
                                r = e.preEnd,
                                o = e.type;
                            if (!1 === this._signals.fire("before-action-".concat(n), e)) return !1;
                            var i = e.iEvent = this._createPreparedEvent(t, n, r, o),
                                a = this.rect;
                            if (a) {
                                var s = this.edges || this.prepared.edges || {
                                    left: !0,
                                    right: !0,
                                    top: !0,
                                    bottom: !0
                                };
                                s.top && (a.top += i.delta.y), s.bottom && (a.bottom += i.delta.y), s.left && (a.left += i.delta.x), s.right && (a.right += i.delta.x), a.width = a.right - a.left, a.height = a.bottom - a.top
                            }
                            return this._signals.fire("action-".concat(n), e), this._fireEvent(i), this._signals.fire("after-action-".concat(n), e), !0
                        }
                    }, {
                        key: "_now",
                        value: function () {
                            return Date.now()
                        }
                    }, {
                        key: "pointerMoveTolerance",
                        get: function () {
                            return 1
                        }
                    }]), l
                }(),
                g = t.Interaction = v;
            t.default = g
        }),
        s = {};

    function t(e, t) {
        for (var n = 0; n < t.length; n++) {
            var r = t[n];
            e.push(r)
        }
        return e
    }

    function n(e, t) {
        for (var n = 0; n < e.length; n++)
            if (t(e[n], n, e)) return n;
        return -1
    }
    Object.defineProperty(s, "__esModule", {
        value: !0
    }), s.contains = function (e, t) {
        return -1 !== e.indexOf(t)
    }, s.remove = function (e, t) {
        return e.splice(e.indexOf(t), 1)
    }, s.merge = t, s.from = function (e) {
        return t([], e)
    }, s.findIndex = n, s.find = function (e, t) {
        return e[n(e, t)]
    };
    var k = {};
    Object.defineProperty(k, "__esModule", {
        value: !0
    }), k.default = void 0;
    var r = {
        init: function (e) {
            var t = e;
            r.document = t.document, r.DocumentFragment = t.DocumentFragment || o, r.SVGElement = t.SVGElement || o, r.SVGSVGElement = t.SVGSVGElement || o, r.SVGElementInstance = t.SVGElementInstance || o, r.Element = t.Element || o, r.HTMLElement = t.HTMLElement || r.Element, r.Event = t.Event, r.Touch = t.Touch || o, r.PointerEvent = t.PointerEvent || t.MSPointerEvent
        },
        document: null,
        DocumentFragment: null,
        SVGElement: null,
        SVGSVGElement: null,
        SVGElementInstance: null,
        Element: null,
        HTMLElement: null,
        Event: null,
        Touch: null,
        PointerEvent: null
    };

    function o() {}
    var i = r;
    k.default = i;
    var u = {};
    Object.defineProperty(u, "__esModule", {
        value: !0
    }), u.default = void 0;
    u.default = function (e) {
        return !(!e || !e.Window) && e instanceof e.Window
    };
    var l = {};
    Object.defineProperty(l, "__esModule", {
        value: !0
    }), l.init = d, l.getWindow = v, l.default = void 0;
    var c, f = (c = u) && c.__esModule ? c : {
        default: c
    };
    var p = {
        realWindow: void 0,
        window: void 0,
        getWindow: v,
        init: d
    };

    function d(e) {
        var t = (p.realWindow = e).document.createTextNode("");
        t.ownerDocument !== e.document && "function" == typeof e.wrap && e.wrap(t) === t && (e = e.wrap(e)), p.window = e
    }

    function v(e) {
        return (0, f.default)(e) ? e : (e.ownerDocument || e).defaultView || p.window
    }
    "undefined" == typeof window ? (p.window = void 0, p.realWindow = void 0) : d(window), p.init = d;
    var g = p;
    l.default = g;
    var y = {};
    Object.defineProperty(y, "__esModule", {
        value: !0
    }), y.array = y.plainObject = y.element = y.string = y.bool = y.number = y.func = y.object = y.docFrag = y.window = void 0;
    var m = w(u),
        b = w(l);

    function w(e) {
        return e && e.__esModule ? e : {
            default: e
        }
    }

    function O(e) {
        return (O = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
            return typeof e
        } : function (e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
        })(e)
    }
    y.window = function (e) {
        return e === b.default.window || (0, m.default)(e)
    };
    y.docFrag = function (e) {
        return P(e) && 11 === e.nodeType
    };
    var P = function (e) {
        return !!e && "object" === O(e)
    };
    y.object = P;

    function _(e) {
        return "function" == typeof e
    }
    y.func = _;
    y.number = function (e) {
        return "number" == typeof e
    };
    y.bool = function (e) {
        return "boolean" == typeof e
    };
    y.string = function (e) {
        return "string" == typeof e
    };
    y.element = function (e) {
        if (!e || "object" !== O(e)) return !1;
        var t = b.default.getWindow(e) || b.default.window;
        return /object|function/.test(O(t.Element)) ? e instanceof t.Element : 1 === e.nodeType && "string" == typeof e.nodeName
    };
    y.plainObject = function (e) {
        return P(e) && !!e.constructor && /function Object\b/.test(e.constructor.toString())
    };
    y.array = function (e) {
        return P(e) && void 0 !== e.length && _(e.splice)
    };
    var M = {};
    Object.defineProperty(M, "__esModule", {
        value: !0
    }), M.default = void 0;
    var x = D(k),
        j = function (e) {
            if (e && e.__esModule) return e;
            var t = T();
            if (t && t.has(e)) return t.get(e);
            var n = {};
            if (null != e) {
                var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
                for (var o in e)
                    if (Object.prototype.hasOwnProperty.call(e, o)) {
                        var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                        i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                    }
            }
            n.default = e, t && t.set(e, n);
            return n
        }(y),
        E = D(l);

    function T() {
        if ("function" != typeof WeakMap) return null;
        var e = new WeakMap;
        return T = function () {
            return e
        }, e
    }

    function D(e) {
        return e && e.__esModule ? e : {
            default: e
        }
    }
    var I = {
        init: function (e) {
            var t = x.default.Element,
                n = E.default.window.navigator;
            I.supportsTouch = "ontouchstart" in e || j.func(e.DocumentTouch) && x.default.document instanceof e.DocumentTouch, I.supportsPointerEvent = !1 !== n.pointerEnabled && !!x.default.PointerEvent, I.isIOS = /iP(hone|od|ad)/.test(n.platform), I.isIOS7 = /iP(hone|od|ad)/.test(n.platform) && /OS 7[^\d]/.test(n.appVersion), I.isIe9 = /MSIE 9/.test(n.userAgent), I.isOperaMobile = "Opera" === n.appName && I.supportsTouch && /Presto/.test(n.userAgent), I.prefixedMatchesSelector = "matches" in t.prototype ? "matches" : "webkitMatchesSelector" in t.prototype ? "webkitMatchesSelector" : "mozMatchesSelector" in t.prototype ? "mozMatchesSelector" : "oMatchesSelector" in t.prototype ? "oMatchesSelector" : "msMatchesSelector", I.pEventTypes = I.supportsPointerEvent ? x.default.PointerEvent === e.MSPointerEvent ? {
                up: "MSPointerUp",
                down: "MSPointerDown",
                over: "mouseover",
                out: "mouseout",
                move: "MSPointerMove",
                cancel: "MSPointerCancel"
            } : {
                up: "pointerup",
                down: "pointerdown",
                over: "pointerover",
                out: "pointerout",
                move: "pointermove",
                cancel: "pointercancel"
            } : null, I.wheelEvent = "onmousewheel" in x.default.document ? "mousewheel" : "wheel"
        },
        supportsTouch: null,
        supportsPointerEvent: null,
        isIOS7: null,
        isIOS: null,
        isIe9: null,
        isOperaMobile: null,
        prefixedMatchesSelector: null,
        pEventTypes: null,
        wheelEvent: null
    };
    var z = I;
    M.default = z;
    var A = {};
    Object.defineProperty(A, "__esModule", {
        value: !0
    }), A.nodeContains = function (e, t) {
        for (; t;) {
            if (t === e) return !0;
            t = t.parentNode
        }
        return !1
    }, A.closest = function (e, t) {
        for (; W.element(e);) {
            if (V(e, t)) return e;
            e = L(e)
        }
        return null
    }, A.parentNode = L, A.matchesSelector = V, A.indexOfDeepestElement = function (e) {
        var t, n, r = [],
            o = e[0],
            i = o ? 0 : -1;
        for (t = 1; t < e.length; t++) {
            var a = e[t];
            if (a && a !== o)
                if (o) {
                    if (a.parentNode !== a.ownerDocument)
                        if (o.parentNode !== a.ownerDocument)
                            if (a.parentNode !== o.parentNode) {
                                if (!r.length)
                                    for (var s = o, u = void 0;
                                        (u = q(s)) && u !== s.ownerDocument;) r.unshift(s), s = u;
                                var l = void 0;
                                if (o instanceof R.default.HTMLElement && a instanceof R.default.SVGElement && !(a instanceof R.default.SVGSVGElement)) {
                                    if (a === o.parentNode) continue;
                                    l = a.ownerSVGElement
                                } else l = a;
                                for (var c = []; l.parentNode !== l.ownerDocument;) c.unshift(l), l = q(l);
                                for (n = 0; c[n] && c[n] === r[n];) n++;
                                for (var f = [c[n - 1], c[n], r[n]], p = f[0].lastChild; p;) {
                                    if (p === f[1]) {
                                        o = a, i = t, r = c;
                                        break
                                    }
                                    if (p === f[2]) break;
                                    p = p.previousSibling
                                }
                            } else {
                                var d = parseInt((0, X.getWindow)(o).getComputedStyle(o).zIndex, 10) || 0,
                                    v = parseInt((0, X.getWindow)(a).getComputedStyle(a).zIndex, 10) || 0;
                                d <= v && (o = a, i = t)
                            }
                    else o = a, i = t
                } else o = a, i = t
        }
        return i
    }, A.matchesUpTo = function (e, t, n) {
        for (; W.element(e);) {
            if (V(e, t)) return !0;
            if ((e = L(e)) === n) return V(e, t)
        }
        return !1
    }, A.getActualElement = function (e) {
        return e instanceof R.default.SVGElementInstance ? e.correspondingUseElement : e
    }, A.getScrollXY = G, A.getElementClientRect = U, A.getElementRect = function (e) {
        var t = U(e);
        if (!C.default.isIOS7 && t) {
            var n = G(X.default.getWindow(e));
            t.left += n.x, t.right += n.x, t.top += n.y, t.bottom += n.y
        }
        return t
    }, A.getPath = function (e) {
        var t = [];
        for (; e;) t.push(e), e = L(e);
        return t
    }, A.trySelector = function (e) {
        return !!W.string(e) && (R.default.document.querySelector(e), !0)
    };
    var C = F(M),
        R = F(k),
        W = N(y),
        X = N(l);

    function Y() {
        if ("function" != typeof WeakMap) return null;
        var e = new WeakMap;
        return Y = function () {
            return e
        }, e
    }

    function N(e) {
        if (e && e.__esModule) return e;
        var t = Y();
        if (t && t.has(e)) return t.get(e);
        var n = {};
        if (null != e) {
            var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
            for (var o in e)
                if (Object.prototype.hasOwnProperty.call(e, o)) {
                    var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                    i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                }
        }
        return n.default = e, t && t.set(e, n), n
    }

    function F(e) {
        return e && e.__esModule ? e : {
            default: e
        }
    }

    function L(e) {
        var t = e.parentNode;
        if (W.docFrag(t)) {
            for (;
                (t = t.host) && W.docFrag(t););
            return t
        }
        return t
    }

    function V(e, t) {
        return X.default.window !== X.default.realWindow && (t = t.replace(/\/deep\//g, " ")), e[C.default.prefixedMatchesSelector](t)
    }
    var q = function (e) {
        return e.parentNode ? e.parentNode : e.host
    };

    function G(e) {
        return {
            x: (e = e || X.default.window).scrollX || e.document.documentElement.scrollLeft,
            y: e.scrollY || e.document.documentElement.scrollTop
        }
    }

    function U(e) {
        var t = e instanceof R.default.SVGElement ? e.getBoundingClientRect() : e.getClientRects()[0];
        return t && {
            left: t.left,
            right: t.right,
            top: t.top,
            bottom: t.bottom,
            width: t.width || t.right - t.left,
            height: t.height || t.bottom - t.top
        }
    }
    var B = {};
    Object.defineProperty(B, "__esModule", {
        value: !0
    }), B.default = function e(t) {
        var n = {};
        for (var r in t) {
            var o = t[r];
            $.plainObject(o) ? n[r] = e(o) : $.array(o) ? n[r] = H.from(o) : n[r] = o
        }
        return n
    };
    var H = Q(s),
        $ = Q(y);

    function K() {
        if ("function" != typeof WeakMap) return null;
        var e = new WeakMap;
        return K = function () {
            return e
        }, e
    }

    function Q(e) {
        if (e && e.__esModule) return e;
        var t = K();
        if (t && t.has(e)) return t.get(e);
        var n = {};
        if (null != e) {
            var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
            for (var o in e)
                if (Object.prototype.hasOwnProperty.call(e, o)) {
                    var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                    i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                }
        }
        return n.default = e, t && t.set(e, n), n
    }
    var J = {};

    function Z(e, t) {
        for (var n in t) {
            var r = Z.prefixedPropREs,
                o = !1;
            for (var i in r)
                if (0 === n.indexOf(i) && r[i].test(n)) {
                    o = !0;
                    break
                } o || "function" == typeof t[n] || (e[n] = t[n])
        }
        return e
    }
    Object.defineProperty(J, "__esModule", {
        value: !0
    }), J.default = void 0, Z.prefixedPropREs = {
        webkit: /(Movement[XY]|Radius[XY]|RotationAngle|Force)$/,
        moz: /(Pressure)$/
    };
    var ee = Z;
    J.default = ee;
    var te = {};
    Object.defineProperty(te, "__esModule", {
        value: !0
    }), te.default = void 0;
    te.default = function (e, t) {
        return Math.sqrt(e * e + t * t)
    };
    var ne = {};
    Object.defineProperty(ne, "__esModule", {
        value: !0
    }), ne.default = void 0;
    var re = ce(M),
        oe = ce(k),
        ie = le(A),
        ae = ce(te),
        se = le(y);

    function ue() {
        if ("function" != typeof WeakMap) return null;
        var e = new WeakMap;
        return ue = function () {
            return e
        }, e
    }

    function le(e) {
        if (e && e.__esModule) return e;
        var t = ue();
        if (t && t.has(e)) return t.get(e);
        var n = {};
        if (null != e) {
            var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
            for (var o in e)
                if (Object.prototype.hasOwnProperty.call(e, o)) {
                    var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                    i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                }
        }
        return n.default = e, t && t.set(e, n), n
    }

    function ce(e) {
        return e && e.__esModule ? e : {
            default: e
        }
    }
    var fe = {
            copyCoords: function (e, t) {
                e.page = e.page || {}, e.page.x = t.page.x, e.page.y = t.page.y, e.client = e.client || {}, e.client.x = t.client.x, e.client.y = t.client.y, e.timeStamp = t.timeStamp
            },
            setCoordDeltas: function (e, t, n) {
                e.page.x = n.page.x - t.page.x, e.page.y = n.page.y - t.page.y, e.client.x = n.client.x - t.client.x, e.client.y = n.client.y - t.client.y, e.timeStamp = n.timeStamp - t.timeStamp
            },
            setCoordVelocity: function (e, t) {
                var n = Math.max(t.timeStamp / 1e3, .001);
                e.page.x = t.page.x / n, e.page.y = t.page.y / n, e.client.x = t.client.x / n, e.client.y = t.client.y / n, e.timeStamp = n
            },
            isNativePointer: function (e) {
                return e instanceof oe.default.Event || e instanceof oe.default.Touch
            },
            getXY: function (e, t, n) {
                return (n = n || {}).x = t[(e = e || "page") + "X"], n.y = t[e + "Y"], n
            },
            getPageXY: function (e, t) {
                return t = t || {
                    x: 0,
                    y: 0
                }, re.default.isOperaMobile && fe.isNativePointer(e) ? (fe.getXY("screen", e, t), t.x += window.scrollX, t.y += window.scrollY) : fe.getXY("page", e, t), t
            },
            getClientXY: function (e, t) {
                return t = t || {}, re.default.isOperaMobile && fe.isNativePointer(e) ? fe.getXY("screen", e, t) : fe.getXY("client", e, t), t
            },
            getPointerId: function (e) {
                return se.number(e.pointerId) ? e.pointerId : e.identifier
            },
            setCoords: function (e, t, n) {
                var r = 1 < t.length ? fe.pointerAverage(t) : t[0],
                    o = {};
                fe.getPageXY(r, o), e.page.x = o.x, e.page.y = o.y, fe.getClientXY(r, o), e.client.x = o.x, e.client.y = o.y, e.timeStamp = n
            },
            pointerExtend: ce(J).default,
            getTouchPair: function (e) {
                var t = [];
                return se.array(e) ? (t[0] = e[0], t[1] = e[1]) : "touchend" === e.type ? 1 === e.touches.length ? (t[0] = e.touches[0], t[1] = e.changedTouches[0]) : 0 === e.touches.length && (t[0] = e.changedTouches[0], t[1] = e.changedTouches[1]) : (t[0] = e.touches[0], t[1] = e.touches[1]), t
            },
            pointerAverage: function (e) {
                for (var t = {
                        pageX: 0,
                        pageY: 0,
                        clientX: 0,
                        clientY: 0,
                        screenX: 0,
                        screenY: 0
                    }, n = 0; n < e.length; n++) {
                    var r = e[n];
                    for (var o in t) t[o] += r[o]
                }
                for (var i in t) t[i] /= e.length;
                return t
            },
            touchBBox: function (e) {
                if (!(e.length || e.touches && 1 < e.touches.length)) return null;
                var t = fe.getTouchPair(e),
                    n = Math.min(t[0].pageX, t[1].pageX),
                    r = Math.min(t[0].pageY, t[1].pageY),
                    o = Math.max(t[0].pageX, t[1].pageX),
                    i = Math.max(t[0].pageY, t[1].pageY);
                return {
                    x: n,
                    y: r,
                    left: n,
                    top: r,
                    right: o,
                    bottom: i,
                    width: o - n,
                    height: i - r
                }
            },
            touchDistance: function (e, t) {
                var n = t + "X",
                    r = t + "Y",
                    o = fe.getTouchPair(e),
                    i = o[0][n] - o[1][n],
                    a = o[0][r] - o[1][r];
                return (0, ae.default)(i, a)
            },
            touchAngle: function (e, t) {
                var n = t + "X",
                    r = t + "Y",
                    o = fe.getTouchPair(e),
                    i = o[1][n] - o[0][n],
                    a = o[1][r] - o[0][r];
                return 180 * Math.atan2(a, i) / Math.PI
            },
            getPointerType: function (e) {
                return se.string(e.pointerType) ? e.pointerType : se.number(e.pointerType) ? [void 0, void 0, "touch", "pen", "mouse"][e.pointerType] : /touch/.test(e.type) || e instanceof oe.default.Touch ? "touch" : "mouse"
            },
            getEventTargets: function (e) {
                var t = se.func(e.composedPath) ? e.composedPath() : e.path;
                return [ie.getActualElement(t ? t[0] : e.target), ie.getActualElement(e.currentTarget)]
            },
            newCoords: function () {
                return {
                    page: {
                        x: 0,
                        y: 0
                    },
                    client: {
                        x: 0,
                        y: 0
                    },
                    timeStamp: 0
                }
            },
            coordsToEvent: function (e) {
                return {
                    coords: e,
                    get page() {
                        return this.coords.page
                    },
                    get client() {
                        return this.coords.client
                    },
                    get timeStamp() {
                        return this.coords.timeStamp
                    },
                    get pageX() {
                        return this.coords.page.x
                    },
                    get pageY() {
                        return this.coords.page.y
                    },
                    get clientX() {
                        return this.coords.client.x
                    },
                    get clientY() {
                        return this.coords.client.y
                    },
                    get pointerId() {
                        return this.coords.pointerId
                    },
                    get target() {
                        return this.coords.target
                    },
                    get type() {
                        return this.coords.type
                    },
                    get pointerType() {
                        return this.coords.pointerType
                    },
                    get buttons() {
                        return this.coords.buttons
                    }
                }
            }
        },
        pe = fe;
    ne.default = pe;
    var de = {};
    Object.defineProperty(de, "__esModule", {
        value: !0
    }), de.default = de.FakeEvent = void 0;
    var ve = we(A),
        ge = we(y),
        he = me(J),
        ye = me(ne);

    function me(e) {
        return e && e.__esModule ? e : {
            default: e
        }
    }

    function be() {
        if ("function" != typeof WeakMap) return null;
        var e = new WeakMap;
        return be = function () {
            return e
        }, e
    }

    function we(e) {
        if (e && e.__esModule) return e;
        var t = be();
        if (t && t.has(e)) return t.get(e);
        var n = {};
        if (null != e) {
            var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
            for (var o in e)
                if (Object.prototype.hasOwnProperty.call(e, o)) {
                    var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                    i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                }
        }
        return n.default = e, t && t.set(e, n), n
    }

    function Oe(e, t) {
        for (var n = 0; n < t.length; n++) {
            var r = t[n];
            r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
        }
    }

    function Pe(e, t) {
        return function (e) {
            if (Array.isArray(e)) return e
        }(e) || function (e, t) {
            if (!(Symbol.iterator in Object(e) || "[object Arguments]" === Object.prototype.toString.call(e))) return;
            var n = [],
                r = !0,
                o = !1,
                i = void 0;
            try {
                for (var a, s = e[Symbol.iterator](); !(r = (a = s.next()).done) && (n.push(a.value), !t || n.length !== t); r = !0);
            } catch (e) {
                o = !0, i = e
            } finally {
                try {
                    r || null == s.return || s.return()
                } finally {
                    if (o) throw i
                }
            }
            return n
        }(e, t) || function () {
            throw new TypeError("Invalid attempt to destructure non-iterable instance")
        }()
    }
    var _e = [],
        xe = [],
        je = {},
        Me = [];

    function Ee(e, t, n, r) {
        var o = De(r),
            i = _e.indexOf(e),
            a = xe[i];
        a || (a = {
            events: {},
            typeCount: 0
        }, i = _e.push(e) - 1, xe.push(a)), a.events[t] || (a.events[t] = [], a.typeCount++), (0, s.contains)(a.events[t], n) || (e.addEventListener(t, n, ze.supportsOptions ? o : !!o.capture), a.events[t].push(n))
    }

    function Se(e, t, n, r) {
        var o = De(r),
            i = _e.indexOf(e),
            a = xe[i];
        if (a && a.events)
            if ("all" !== t) {
                if (a.events[t]) {
                    var s = a.events[t].length;
                    if ("all" === n) {
                        for (var u = 0; u < s; u++) Se(e, t, a.events[t][u], o);
                        return
                    }
                    for (var l = 0; l < s; l++)
                        if (a.events[t][l] === n) {
                            e.removeEventListener(t, n, ze.supportsOptions ? o : !!o.capture), a.events[t].splice(l, 1);
                            break
                        } a.events[t] && 0 === a.events[t].length && (a.events[t] = null, a.typeCount--)
                }
                a.typeCount || (xe.splice(i, 1), _e.splice(i, 1))
            } else
                for (t in a.events) a.events.hasOwnProperty(t) && Se(e, t, "all")
    }

    function ke(e, t) {
        for (var n = De(t), r = new Ie(e), o = je[e.type], i = Pe(ye.default.getEventTargets(e), 1)[0], a = i; ge.element(a);) {
            for (var s = 0; s < o.selectors.length; s++) {
                var u = o.selectors[s],
                    l = o.contexts[s];
                if (ve.matchesSelector(a, u) && ve.nodeContains(l, i) && ve.nodeContains(l, a)) {
                    var c = o.listeners[s];
                    r.currentTarget = a;
                    for (var f = 0; f < c.length; f++) {
                        var p = Pe(c[f], 3),
                            d = p[0],
                            v = p[1],
                            g = p[2];
                        v === !!n.capture && g === n.passive && d(r)
                    }
                }
            }
            a = ve.parentNode(a)
        }
    }

    function Te(e) {
        return ke.call(this, e, !0)
    }

    function De(e) {
        return ge.object(e) ? e : {
            capture: e
        }
    }
    var Ie = function () {
        function t(e) {
            ! function (e, t) {
                if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
            }(this, t), this.originalEvent = e, (0, he.default)(this, e)
        }
        return function (e, t, n) {
            t && Oe(e.prototype, t), n && Oe(e, n)
        }(t, [{
            key: "preventOriginalDefault",
            value: function () {
                this.originalEvent.preventDefault()
            }
        }, {
            key: "stopPropagation",
            value: function () {
                this.originalEvent.stopPropagation()
            }
        }, {
            key: "stopImmediatePropagation",
            value: function () {
                this.originalEvent.stopImmediatePropagation()
            }
        }]), t
    }();
    de.FakeEvent = Ie;
    var ze = {
            add: Ee,
            remove: Se,
            addDelegate: function (e, t, n, r, o) {
                var i = De(o);
                if (!je[n]) {
                    je[n] = {
                        contexts: [],
                        listeners: [],
                        selectors: []
                    };
                    for (var a = 0; a < Me.length; a++) {
                        var s = Me[a];
                        Ee(s, n, ke), Ee(s, n, Te, !0)
                    }
                }
                var u, l = je[n];
                for (u = l.selectors.length - 1; 0 <= u && (l.selectors[u] !== e || l.contexts[u] !== t); u--); - 1 === u && (u = l.selectors.length, l.selectors.push(e), l.contexts.push(t), l.listeners.push([])), l.listeners[u].push([r, !!i.capture, i.passive])
            },
            removeDelegate: function (e, t, n, r, o) {
                var i, a = De(o),
                    s = je[n],
                    u = !1;
                if (s)
                    for (i = s.selectors.length - 1; 0 <= i; i--)
                        if (s.selectors[i] === e && s.contexts[i] === t) {
                            for (var l = s.listeners[i], c = l.length - 1; 0 <= c; c--) {
                                var f = Pe(l[c], 3),
                                    p = f[0],
                                    d = f[1],
                                    v = f[2];
                                if (p === r && d === !!a.capture && v === a.passive) {
                                    l.splice(c, 1), l.length || (s.selectors.splice(i, 1), s.contexts.splice(i, 1), s.listeners.splice(i, 1), Se(t, n, ke), Se(t, n, Te, !0), s.selectors.length || (je[n] = null)), u = !0;
                                    break
                                }
                            }
                            if (u) break
                        }
            },
            delegateListener: ke,
            delegateUseCapture: Te,
            delegatedEvents: je,
            documents: Me,
            supportsOptions: !1,
            supportsPassive: !1,
            _elements: _e,
            _targets: xe,
            init: function (e) {
                e.document.createElement("div").addEventListener("test", null, {
                    get capture() {
                        return ze.supportsOptions = !0
                    },
                    get passive() {
                        return ze.supportsPassive = !0
                    }
                })
            }
        },
        Ae = ze;
    de.default = Ae;
    var Ce = {};
    Object.defineProperty(Ce, "__esModule", {
        value: !0
    }), Ce.default = function (e, t) {
        for (var n in t) e[n] = t[n];
        return e
    };
    var Re = {};
    Object.defineProperty(Re, "__esModule", {
        value: !0
    }), Re.getStringOptionResult = Le, Re.resolveRectLike = Ve, Re.rectToXY = qe, Re.xywhToTlbr = Ge, Re.tlbrToXywh = Ue, Re.default = void 0;
    var We, Xe = (We = Ce) && We.__esModule ? We : {
            default: We
        },
        Ye = function (e) {
            if (e && e.__esModule) return e;
            var t = Ne();
            if (t && t.has(e)) return t.get(e);
            var n = {};
            if (null != e) {
                var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
                for (var o in e)
                    if (Object.prototype.hasOwnProperty.call(e, o)) {
                        var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                        i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                    }
            }
            n.default = e, t && t.set(e, n);
            return n
        }(y);

    function Ne() {
        if ("function" != typeof WeakMap) return null;
        var e = new WeakMap;
        return Ne = function () {
            return e
        }, e
    }

    function Fe(e) {
        return function (e) {
            if (Array.isArray(e)) {
                for (var t = 0, n = new Array(e.length); t < e.length; t++) n[t] = e[t];
                return n
            }
        }(e) || function (e) {
            if (Symbol.iterator in Object(e) || "[object Arguments]" === Object.prototype.toString.call(e)) return Array.from(e)
        }(e) || function () {
            throw new TypeError("Invalid attempt to spread non-iterable instance")
        }()
    }

    function Le(e, t, n) {
        return "parent" === e ? (0, A.parentNode)(n) : "self" === e ? t.getRect(n) : (0, A.closest)(n, e)
    }

    function Ve(e, t, n, r) {
        return Ye.string(e) ? e = Le(e, t, n) : Ye.func(e) && (e = e.apply(void 0, Fe(r))), Ye.element(e) && (e = (0, A.getElementRect)(e)), e
    }

    function qe(e) {
        return e && {
            x: "x" in e ? e.x : e.left,
            y: "y" in e ? e.y : e.top
        }
    }

    function Ge(e) {
        return !e || "left" in e && "top" in e || ((e = (0, Xe.default)({}, e)).left = e.x || 0, e.top = e.y || 0, e.right = e.right || e.left + e.width, e.bottom = e.bottom || e.top + e.height), e
    }

    function Ue(e) {
        return !e || "x" in e && "y" in e || ((e = (0, Xe.default)({}, e)).x = e.left || 0, e.y = e.top || 0, e.width = e.width || e.right - e.x, e.height = e.height || e.bottom - e.y), e
    }
    var Be = {
        getStringOptionResult: Le,
        resolveRectLike: Ve,
        rectToXY: qe,
        xywhToTlbr: Ge,
        tlbrToXywh: Ue
    };
    Re.default = Be;
    var He = {};
    Object.defineProperty(He, "__esModule", {
        value: !0
    }), He.default = function (e, t, n) {
        var r = e.options[n],
            o = r && r.origin || e.options.origin,
            i = (0, Re.resolveRectLike)(o, e, t, [e && t]);
        return (0, Re.rectToXY)(i) || {
            x: 0,
            y: 0
        }
    };
    var $e = {};
    Object.defineProperty($e, "__esModule", {
        value: !0
    }), $e.default = function n(t, r, o) {
        o = o || {};
        Je.string(t) && -1 !== t.search(" ") && (t = et(t));
        if (Je.array(t)) return t.reduce(function (e, t) {
            return (0, Qe.default)(e, n(t, r, o))
        }, o);
        Je.object(t) && (r = t, t = "");
        if (Je.func(r)) o[t] = o[t] || [], o[t].push(r);
        else if (Je.array(r))
            for (var e = 0; e < r.length; e++) {
                var i = r[e];
                n(t, i, o)
            } else if (Je.object(r))
                for (var a in r) {
                    var s = et(a).map(function (e) {
                        return "".concat(t).concat(e)
                    });
                    n(s, r[a], o)
                }
        return o
    };
    var Ke, Qe = (Ke = Ce) && Ke.__esModule ? Ke : {
            default: Ke
        },
        Je = function (e) {
            if (e && e.__esModule) return e;
            var t = Ze();
            if (t && t.has(e)) return t.get(e);
            var n = {};
            if (null != e) {
                var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
                for (var o in e)
                    if (Object.prototype.hasOwnProperty.call(e, o)) {
                        var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                        i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                    }
            }
            n.default = e, t && t.set(e, n);
            return n
        }(y);

    function Ze() {
        if ("function" != typeof WeakMap) return null;
        var e = new WeakMap;
        return Ze = function () {
            return e
        }, e
    }

    function et(e) {
        return e.trim().split(/ +/)
    }
    var tt = {};
    Object.defineProperty(tt, "__esModule", {
        value: !0
    }), tt.default = void 0;
    var nt, rt, ot = 0;
    var it = {
        request: function (e) {
            return nt(e)
        },
        cancel: function (e) {
            return rt(e)
        },
        init: function (e) {
            if (nt = e.requestAnimationFrame, rt = e.cancelAnimationFrame, !nt)
                for (var t = ["ms", "moz", "webkit", "o"], n = 0; n < t.length; n++) {
                    var r = t[n];
                    nt = e["".concat(r, "RequestAnimationFrame")], rt = e["".concat(r, "CancelAnimationFrame")] || e["".concat(r, "CancelRequestAnimationFrame")]
                }
            nt || (nt = function (e) {
                var t = Date.now(),
                    n = Math.max(0, 16 - (t - ot)),
                    r = setTimeout(function () {
                        e(t + n)
                    }, n);
                return ot = t + n, r
            }, rt = function (e) {
                return clearTimeout(e)
            })
        }
    };
    tt.default = it;
    var at = {};

    function st(e, t) {
        for (var n = 0; n < t.length; n++) {
            var r = t[n];
            r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
        }
    }
    Object.defineProperty(at, "__esModule", {
        value: !0
    }), at.default = void 0;
    var ut = function () {
        function e() {
            ! function (e, t) {
                if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
            }(this, e), this.listeners = {}
        }
        return function (e, t, n) {
            t && st(e.prototype, t), n && st(e, n)
        }(e, [{
            key: "on",
            value: function (e, t) {
                this.listeners[e] ? this.listeners[e].push(t) : this.listeners[e] = [t]
            }
        }, {
            key: "off",
            value: function (e, t) {
                if (this.listeners[e]) {
                    var n = this.listeners[e].indexOf(t); - 1 !== n && this.listeners[e].splice(n, 1)
                }
            }
        }, {
            key: "fire",
            value: function (e, t) {
                var n = this.listeners[e];
                if (n)
                    for (var r = 0; r < n.length; r++) {
                        if (!1 === (0, n[r])(t, e)) return !1
                    }
            }
        }]), e
    }();
    at.default = ut;
    var lt = {};
    Object.defineProperty(lt, "__esModule", {
        value: !0
    }), lt.warnOnce = function (e, t) {
        var n = !1;
        return function () {
            return n || (dt.default.window.console.warn(t), n = !0), e.apply(this, arguments)
        }
    }, lt._getQBezierValue = St, lt.getQuadraticCurvePoint = function (e, t, n, r, o, i, a) {
        return {
            x: St(a, e, n, o),
            y: St(a, t, r, i)
        }
    }, lt.easeOutQuad = function (e, t, n, r) {
        return -n * (e /= r) * (e - 2) + t
    }, lt.copyAction = function (e, t) {
        return e.name = t.name, e.axis = t.axis, e.edges = t.edges, e
    }, Object.defineProperty(lt, "win", {
        enumerable: !0,
        get: function () {
            return dt.default
        }
    }), Object.defineProperty(lt, "browser", {
        enumerable: !0,
        get: function () {
            return vt.default
        }
    }), Object.defineProperty(lt, "clone", {
        enumerable: !0,
        get: function () {
            return gt.default
        }
    }), Object.defineProperty(lt, "events", {
        enumerable: !0,
        get: function () {
            return ht.default
        }
    }), Object.defineProperty(lt, "extend", {
        enumerable: !0,
        get: function () {
            return yt.default
        }
    }), Object.defineProperty(lt, "getOriginXY", {
        enumerable: !0,
        get: function () {
            return mt.default
        }
    }), Object.defineProperty(lt, "hypot", {
        enumerable: !0,
        get: function () {
            return bt.default
        }
    }), Object.defineProperty(lt, "normalizeListeners", {
        enumerable: !0,
        get: function () {
            return wt.default
        }
    }), Object.defineProperty(lt, "pointer", {
        enumerable: !0,
        get: function () {
            return Ot.default
        }
    }), Object.defineProperty(lt, "raf", {
        enumerable: !0,
        get: function () {
            return Pt.default
        }
    }), Object.defineProperty(lt, "rect", {
        enumerable: !0,
        get: function () {
            return _t.default
        }
    }), Object.defineProperty(lt, "Signals", {
        enumerable: !0,
        get: function () {
            return xt.default
        }
    }), lt.is = lt.dom = lt.arr = void 0;
    var ct = Et(s);
    lt.arr = ct;
    var ft = Et(A);
    lt.dom = ft;
    var pt = Et(y);
    lt.is = pt;
    var dt = jt(l),
        vt = jt(M),
        gt = jt(B),
        ht = jt(de),
        yt = jt(Ce),
        mt = jt(He),
        bt = jt(te),
        wt = jt($e),
        Ot = jt(ne),
        Pt = jt(tt),
        _t = jt(Re),
        xt = jt(at);

    function jt(e) {
        return e && e.__esModule ? e : {
            default: e
        }
    }

    function Mt() {
        if ("function" != typeof WeakMap) return null;
        var e = new WeakMap;
        return Mt = function () {
            return e
        }, e
    }

    function Et(e) {
        if (e && e.__esModule) return e;
        var t = Mt();
        if (t && t.has(e)) return t.get(e);
        var n = {};
        if (null != e) {
            var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
            for (var o in e)
                if (Object.prototype.hasOwnProperty.call(e, o)) {
                    var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                    i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                }
        }
        return n.default = e, t && t.set(e, n), n
    }

    function St(e, t, n, r) {
        var o = 1 - e;
        return o * o * t + 2 * o * e * n + e * e * r
    }
    var kt = {};
    Object.defineProperty(kt, "__esModule", {
        value: !0
    }), kt.default = kt.defaults = void 0;
    var Tt = {
            base: {
                preventDefault: "auto",
                deltaSource: "page"
            },
            perAction: {
                enabled: !1,
                origin: {
                    x: 0,
                    y: 0
                }
            },
            actions: {}
        },
        Dt = kt.defaults = Tt;
    kt.default = Dt;
    var It = {};
    Object.defineProperty(It, "__esModule", {
        value: !0
    }), It.default = void 0;
    var zt = function (e) {
            if (e && e.__esModule) return e;
            var t = Wt();
            if (t && t.has(e)) return t.get(e);
            var n = {};
            if (null != e) {
                var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
                for (var o in e)
                    if (Object.prototype.hasOwnProperty.call(e, o)) {
                        var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                        i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                    }
            }
            n.default = e, t && t.set(e, n);
            return n
        }(s),
        At = Rt(Ce),
        Ct = Rt($e);

    function Rt(e) {
        return e && e.__esModule ? e : {
            default: e
        }
    }

    function Wt() {
        if ("function" != typeof WeakMap) return null;
        var e = new WeakMap;
        return Wt = function () {
            return e
        }, e
    }

    function Xt(e, t) {
        for (var n = 0; n < t.length; n++) {
            var r = t[n];
            r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
        }
    }

    function Yt(e, t) {
        for (var n = 0; n < t.length; n++) {
            var r = t[n];
            if (e.immediatePropagationStopped) break;
            r(e)
        }
    }
    var Nt = function () {
        function t(e) {
            ! function (e, t) {
                if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
            }(this, t), this.types = {}, this.propagationStopped = !1, this.immediatePropagationStopped = !1, this.options = (0, At.default)({}, e || {})
        }
        return function (e, t, n) {
            t && Xt(e.prototype, t), n && Xt(e, n)
        }(t, [{
            key: "fire",
            value: function (e) {
                var t, n = this.global;
                (t = this.types[e.type]) && Yt(e, t), !e.propagationStopped && n && (t = n[e.type]) && Yt(e, t)
            }
        }, {
            key: "on",
            value: function (e, t) {
                var n = (0, Ct.default)(e, t);
                for (e in n) this.types[e] = zt.merge(this.types[e] || [], n[e])
            }
        }, {
            key: "off",
            value: function (e, t) {
                var n = (0, Ct.default)(e, t);
                for (e in n) {
                    var r = this.types[e];
                    if (r && r.length)
                        for (var o = 0; o < n[e].length; o++) {
                            var i = n[e][o],
                                a = r.indexOf(i); - 1 !== a && r.splice(a, 1)
                        }
                }
            }
        }, {
            key: "getRect",
            value: function () {
                return null
            }
        }]), t
    }();
    It.default = Nt;
    var Ft = {};
    Object.defineProperty(Ft, "__esModule", {
        value: !0
    }), Ft.default = Ft.Interactable = void 0;
    var Lt = Jt(s),
        Vt = Kt(M),
        qt = Kt(B),
        Gt = Kt(de),
        Ut = Kt(Ce),
        Bt = Jt(y),
        Ht = Kt($e),
        $t = Kt(It);

    function Kt(e) {
        return e && e.__esModule ? e : {
            default: e
        }
    }

    function Qt() {
        if ("function" != typeof WeakMap) return null;
        var e = new WeakMap;
        return Qt = function () {
            return e
        }, e
    }

    function Jt(e) {
        if (e && e.__esModule) return e;
        var t = Qt();
        if (t && t.has(e)) return t.get(e);
        var n = {};
        if (null != e) {
            var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
            for (var o in e)
                if (Object.prototype.hasOwnProperty.call(e, o)) {
                    var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                    i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                }
        }
        return n.default = e, t && t.set(e, n), n
    }

    function Zt(e, t) {
        for (var n = 0; n < t.length; n++) {
            var r = t[n];
            r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
        }
    }
    var en = function () {
            function r(e, t, n) {
                ! function (e, t) {
                    if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
                }(this, r), this.events = new $t.default, this._actions = t.actions, this.target = e, this._context = t.context || n, this._win = (0, l.getWindow)((0, A.trySelector)(e) ? this._context : e), this._doc = this._win.document, this.set(t)
            }
            return function (e, t, n) {
                t && Zt(e.prototype, t), n && Zt(e, n)
            }(r, [{
                key: "setOnEvents",
                value: function (e, t) {
                    return Bt.func(t.onstart) && this.on("".concat(e, "start"), t.onstart), Bt.func(t.onmove) && this.on("".concat(e, "move"), t.onmove), Bt.func(t.onend) && this.on("".concat(e, "end"), t.onend), Bt.func(t.oninertiastart) && this.on("".concat(e, "inertiastart"), t.oninertiastart), this
                }
            }, {
                key: "updatePerActionListeners",
                value: function (e, t, n) {
                    (Bt.array(t) || Bt.object(t)) && this.off(e, t), (Bt.array(n) || Bt.object(n)) && this.on(e, n)
                }
            }, {
                key: "setPerAction",
                value: function (e, t) {
                    var n = this._defaults;
                    for (var r in t) {
                        var o = this.options[e],
                            i = t[r],
                            a = Bt.array(i);
                        "listeners" === r && this.updatePerActionListeners(e, o.listeners, i), a ? o[r] = Lt.from(i) : !a && Bt.plainObject(i) ? (o[r] = (0, Ut.default)(o[r] || {}, (0, qt.default)(i)), Bt.object(n.perAction[r]) && "enabled" in n.perAction[r] && (o[r].enabled = !1 !== i.enabled)) : Bt.bool(i) && Bt.object(n.perAction[r]) ? o[r].enabled = i : o[r] = i
                    }
                }
            }, {
                key: "getRect",
                value: function (e) {
                    return e = e || (Bt.element(this.target) ? this.target : null), Bt.string(this.target) && (e = e || this._context.querySelector(this.target)), (0, A.getElementRect)(e)
                }
            }, {
                key: "rectChecker",
                value: function (e) {
                    return Bt.func(e) ? (this.getRect = e, this) : null === e ? (delete this.getRect, this) : this.getRect
                }
            }, {
                key: "_backCompatOption",
                value: function (e, t) {
                    if ((0, A.trySelector)(t) || Bt.object(t)) {
                        this.options[e] = t;
                        for (var n = 0; n < this._actions.names.length; n++) {
                            var r = this._actions.names[n];
                            this.options[r][e] = t
                        }
                        return this
                    }
                    return this.options[e]
                }
            }, {
                key: "origin",
                value: function (e) {
                    return this._backCompatOption("origin", e)
                }
            }, {
                key: "deltaSource",
                value: function (e) {
                    return "page" === e || "client" === e ? (this.options.deltaSource = e, this) : this.options.deltaSource
                }
            }, {
                key: "context",
                value: function () {
                    return this._context
                }
            }, {
                key: "inContext",
                value: function (e) {
                    return this._context === e.ownerDocument || (0, A.nodeContains)(this._context, e)
                }
            }, {
                key: "testIgnoreAllow",
                value: function (e, t, n) {
                    return !this.testIgnore(e.ignoreFrom, t, n) && this.testAllow(e.allowFrom, t, n)
                }
            }, {
                key: "testAllow",
                value: function (e, t, n) {
                    return !e || !!Bt.element(n) && (Bt.string(e) ? (0, A.matchesUpTo)(n, e, t) : !!Bt.element(e) && (0, A.nodeContains)(e, n))
                }
            }, {
                key: "testIgnore",
                value: function (e, t, n) {
                    return !(!e || !Bt.element(n)) && (Bt.string(e) ? (0, A.matchesUpTo)(n, e, t) : !!Bt.element(e) && (0, A.nodeContains)(e, n))
                }
            }, {
                key: "fire",
                value: function (e) {
                    return this.events.fire(e), this
                }
            }, {
                key: "_onOff",
                value: function (e, t, n, r) {
                    Bt.object(t) && !Bt.array(t) && (r = n, n = null);
                    var o = "on" === e ? "add" : "remove",
                        i = (0, Ht.default)(t, n);
                    for (var a in i) {
                        "wheel" === a && (a = Vt.default.wheelEvent);
                        for (var s = 0; s < i[a].length; s++) {
                            var u = i[a][s];
                            Lt.contains(this._actions.eventTypes, a) ? this.events[e](a, u) : Bt.string(this.target) ? Gt.default["".concat(o, "Delegate")](this.target, this._context, a, u, r) : Gt.default[o](this.target, a, u, r)
                        }
                    }
                    return this
                }
            }, {
                key: "on",
                value: function (e, t, n) {
                    return this._onOff("on", e, t, n)
                }
            }, {
                key: "off",
                value: function (e, t, n) {
                    return this._onOff("off", e, t, n)
                }
            }, {
                key: "set",
                value: function (e) {
                    var t = this._defaults;
                    for (var n in Bt.object(e) || (e = {}), this.options = (0, qt.default)(t.base), this._actions.methodDict) {
                        var r = this._actions.methodDict[n];
                        this.options[n] = {}, this.setPerAction(n, (0, Ut.default)((0, Ut.default)({}, t.perAction), t.actions[n])), this[r](e[n])
                    }
                    for (var o in e) Bt.func(this[o]) && this[o](e[o]);
                    return this
                }
            }, {
                key: "unset",
                value: function () {
                    if (Gt.default.remove(this.target, "all"), Bt.string(this.target))
                        for (var e in Gt.default.delegatedEvents) {
                            var t = Gt.default.delegatedEvents[e];
                            t.selectors[0] === this.target && t.contexts[0] === this._context && (t.selectors.splice(0, 1), t.contexts.splice(0, 1), t.listeners.splice(0, 1), t.selectors.length || (t[e] = null)), Gt.default.remove(this._context, e, Gt.default.delegateListener), Gt.default.remove(this._context, e, Gt.default.delegateUseCapture, !0)
                        } else Gt.default.remove(this.target, "all")
                }
            }, {
                key: "_defaults",
                get: function () {
                    return {
                        base: {},
                        perAction: {},
                        actions: {}
                    }
                }
            }]), r
        }(),
        tn = Ft.Interactable = en;
    Ft.default = tn;
    var nn = {};
    Object.defineProperty(nn, "__esModule", {
        value: !0
    }), nn.default = void 0;
    var rn = fn(s),
        on = fn(A),
        an = ln(Ce),
        sn = fn(y),
        un = ln(at);

    function ln(e) {
        return e && e.__esModule ? e : {
            default: e
        }
    }

    function cn() {
        if ("function" != typeof WeakMap) return null;
        var e = new WeakMap;
        return cn = function () {
            return e
        }, e
    }

    function fn(e) {
        if (e && e.__esModule) return e;
        var t = cn();
        if (t && t.has(e)) return t.get(e);
        var n = {};
        if (null != e) {
            var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
            for (var o in e)
                if (Object.prototype.hasOwnProperty.call(e, o)) {
                    var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                    i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                }
        }
        return n.default = e, t && t.set(e, n), n
    }

    function pn(e, t) {
        for (var n = 0; n < t.length; n++) {
            var r = t[n];
            r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
        }
    }
    var dn = function () {
        function t(e) {
            var a = this;
            ! function (e, t) {
                if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
            }(this, t), this.scope = e, this.signals = new un.default, this.list = [], this.selectorMap = {}, this.signals.on("unset", function (e) {
                var t = e.interactable,
                    n = t.target,
                    r = t._context,
                    o = sn.string(n) ? a.selectorMap[n] : n[a.scope.id],
                    i = o.findIndex(function (e) {
                        return e.context === r
                    });
                o[i] && (o[i].context = null, o[i].interactable = null), o.splice(i, 1)
            })
        }
        return function (e, t, n) {
            t && pn(e.prototype, t), n && pn(e, n)
        }(t, [{
            key: "new",
            value: function (e, t) {
                t = (0, an.default)(t || {}, {
                    actions: this.scope.actions
                });
                var n = new this.scope.Interactable(e, t, this.scope.document),
                    r = {
                        context: n._context,
                        interactable: n
                    };
                return this.scope.addDocument(n._doc), this.list.push(n), sn.string(e) ? (this.selectorMap[e] || (this.selectorMap[e] = []), this.selectorMap[e].push(r)) : (n.target[this.scope.id] || Object.defineProperty(e, this.scope.id, {
                    value: [],
                    configurable: !0
                }), e[this.scope.id].push(r)), this.signals.fire("new", {
                    target: e,
                    options: t,
                    interactable: n,
                    win: this.scope._win
                }), n
            }
        }, {
            key: "get",
            value: function (t, e) {
                var n = e && e.context || this.scope.document,
                    r = sn.string(t),
                    o = r ? this.selectorMap[t] : t[this.scope.id];
                if (!o) return null;
                var i = rn.find(o, function (e) {
                    return e.context === n && (r || e.interactable.inContext(t))
                });
                return i && i.interactable
            }
        }, {
            key: "forEachMatch",
            value: function (e, t) {
                for (var n = 0; n < this.list.length; n++) {
                    var r = this.list[n],
                        o = void 0;
                    if ((sn.string(r.target) ? sn.element(e) && on.matchesSelector(e, r.target) : e === r.target) && r.inContext(e) && (o = t(r)), void 0 !== o) return o
                }
            }
        }]), t
    }();
    nn.default = dn;
    var vn, gn, hn = {};

    function yn(e, t) {
        for (var n = 0; n < t.length; n++) {
            var r = t[n];
            r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
        }
    }
    Object.defineProperty(hn, "__esModule", {
        value: !0
    }), hn.default = hn.BaseEvent = hn.EventPhase = void 0, hn.EventPhase = vn, (gn = vn || (hn.EventPhase = vn = {})).Start = "start", gn.Move = "move", gn.End = "end", gn._NONE = "";
    var mn = function () {
            function t(e) {
                ! function (e, t) {
                    if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
                }(this, t), this.immediatePropagationStopped = !1, this.propagationStopped = !1, this._interaction = e
            }
            return function (e, t, n) {
                t && yn(e.prototype, t), n && yn(e, n)
            }(t, [{
                key: "preventDefault",
                value: function () {}
            }, {
                key: "stopPropagation",
                value: function () {
                    this.propagationStopped = !0
                }
            }, {
                key: "stopImmediatePropagation",
                value: function () {
                    this.immediatePropagationStopped = this.propagationStopped = !0
                }
            }, {
                key: "interaction",
                get: function () {
                    return this._interaction._proxy
                }
            }]), t
        }(),
        bn = hn.BaseEvent = mn;
    hn.default = bn;
    var wn = {};
    Object.defineProperty(wn, "__esModule", {
        value: !0
    }), wn.default = wn.InteractEvent = wn.EventPhase = void 0;
    var On, Pn, _n = Sn(Ce),
        xn = Sn(He),
        jn = Sn(te),
        Mn = Sn(hn),
        En = Sn(kt);

    function Sn(e) {
        return e && e.__esModule ? e : {
            default: e
        }
    }

    function kn(e) {
        return (kn = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
            return typeof e
        } : function (e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
        })(e)
    }

    function Tn(e, t) {
        for (var n = 0; n < t.length; n++) {
            var r = t[n];
            r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
        }
    }

    function Dn(e) {
        return (Dn = Object.setPrototypeOf ? Object.getPrototypeOf : function (e) {
            return e.__proto__ || Object.getPrototypeOf(e)
        })(e)
    }

    function In(e) {
        if (void 0 === e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
        return e
    }

    function zn(e, t) {
        return (zn = Object.setPrototypeOf || function (e, t) {
            return e.__proto__ = t, e
        })(e, t)
    }
    wn.EventPhase = On, (Pn = On || (wn.EventPhase = On = {})).Start = "start", Pn.Move = "move", Pn.End = "end", Pn._NONE = "";
    var An = function () {
            function h(e, t, n, r, o, i, a, s) {
                var u;
                ! function (e, t) {
                    if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
                }(this, h), u = function (e, t) {
                    return !t || "object" !== kn(t) && "function" != typeof t ? In(e) : t
                }(this, Dn(h).call(this, e)), o = o || e.element;
                var l = e.interactable,
                    c = (l && l.options || En.default).deltaSource,
                    f = (0, xn.default)(l, o, n),
                    p = "start" === r,
                    d = "end" === r,
                    v = p ? In(u) : e.prevEvent,
                    g = p ? e.coords.start : d ? {
                        page: v.page,
                        client: v.client,
                        timeStamp: e.coords.cur.timeStamp
                    } : e.coords.cur;
                return u.page = (0, _n.default)({}, g.page), u.client = (0, _n.default)({}, g.client), u.rect = (0, _n.default)({}, e.rect), u.timeStamp = g.timeStamp, d || (u.page.x -= f.x, u.page.y -= f.y, u.client.x -= f.x, u.client.y -= f.y), u.ctrlKey = t.ctrlKey, u.altKey = t.altKey, u.shiftKey = t.shiftKey, u.metaKey = t.metaKey, u.button = t.button, u.buttons = t.buttons, u.target = o, u.currentTarget = o, u.relatedTarget = i || null, u.preEnd = a, u.type = s || n + (r || ""), u.interactable = l, u.t0 = p ? e.pointers[e.pointers.length - 1].downTime : v.t0, u.x0 = e.coords.start.page.x - f.x, u.y0 = e.coords.start.page.y - f.y, u.clientX0 = e.coords.start.client.x - f.x, u.clientY0 = e.coords.start.client.y - f.y, u.delta = p || d ? {
                    x: 0,
                    y: 0
                } : {
                    x: u[c].x - v[c].x,
                    y: u[c].y - v[c].y
                }, u.dt = e.coords.delta.timeStamp, u.duration = u.timeStamp - u.t0, u.velocity = (0, _n.default)({}, e.coords.velocity[c]), u.speed = (0, jn.default)(u.velocity.x, u.velocity.y), u.swipe = d || "inertiastart" === r ? u.getSwipe() : null, u
            }
            return function (e, t) {
                    if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function");
                    e.prototype = Object.create(t && t.prototype, {
                        constructor: {
                            value: e,
                            writable: !0,
                            configurable: !0
                        }
                    }), t && zn(e, t)
                }(h, Mn["default"]),
                function (e, t, n) {
                    t && Tn(e.prototype, t), n && Tn(e, n)
                }(h, [{
                    key: "getSwipe",
                    value: function () {
                        var e = this._interaction;
                        if (e.prevEvent.speed < 600 || 150 < this.timeStamp - e.prevEvent.timeStamp) return null;
                        var t = 180 * Math.atan2(e.prevEvent.velocityY, e.prevEvent.velocityX) / Math.PI;
                        t < 0 && (t += 360);
                        var n = 112.5 <= t && t < 247.5,
                            r = 202.5 <= t && t < 337.5;
                        return {
                            up: r,
                            down: !r && 22.5 <= t && t < 157.5,
                            left: n,
                            right: !n && (292.5 <= t || t < 67.5),
                            angle: t,
                            speed: e.prevEvent.speed,
                            velocity: {
                                x: e.prevEvent.velocityX,
                                y: e.prevEvent.velocityY
                            }
                        }
                    }
                }, {
                    key: "preventDefault",
                    value: function () {}
                }, {
                    key: "stopImmediatePropagation",
                    value: function () {
                        this.immediatePropagationStopped = this.propagationStopped = !0
                    }
                }, {
                    key: "stopPropagation",
                    value: function () {
                        this.propagationStopped = !0
                    }
                }, {
                    key: "pageX",
                    get: function () {
                        return this.page.x
                    },
                    set: function (e) {
                        this.page.x = e
                    }
                }, {
                    key: "pageY",
                    get: function () {
                        return this.page.y
                    },
                    set: function (e) {
                        this.page.y = e
                    }
                }, {
                    key: "clientX",
                    get: function () {
                        return this.client.x
                    },
                    set: function (e) {
                        this.client.x = e
                    }
                }, {
                    key: "clientY",
                    get: function () {
                        return this.client.y
                    },
                    set: function (e) {
                        this.client.y = e
                    }
                }, {
                    key: "dx",
                    get: function () {
                        return this.delta.x
                    },
                    set: function (e) {
                        this.delta.x = e
                    }
                }, {
                    key: "dy",
                    get: function () {
                        return this.delta.y
                    },
                    set: function (e) {
                        this.delta.y = e
                    }
                }, {
                    key: "velocityX",
                    get: function () {
                        return this.velocity.x
                    },
                    set: function (e) {
                        this.velocity.x = e
                    }
                }, {
                    key: "velocityY",
                    get: function () {
                        return this.velocity.y
                    },
                    set: function (e) {
                        this.velocity.y = e
                    }
                }]), h
        }(),
        Cn = wn.InteractEvent = An;
    wn.default = Cn;
    var Rn = {};
    Object.defineProperty(Rn, "__esModule", {
        value: !0
    }), Rn.default = Rn.PointerInfo = void 0;

    function Wn(e, t, n, r, o) {
        ! function (e, t) {
            if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
        }(this, Wn), this.id = e, this.pointer = t, this.event = n, this.downTime = r, this.downTarget = o
    }
    var Xn = Rn.PointerInfo = Wn;
    Rn.default = Xn;
    var Yn = {};
    Object.defineProperty(Yn, "__esModule", {
        value: !0
    }), Yn.default = void 0;
    var Nn = function (e) {
        if (e && e.__esModule) return e;
        var t = Fn();
        if (t && t.has(e)) return t.get(e);
        var n = {};
        if (null != e) {
            var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
            for (var o in e)
                if (Object.prototype.hasOwnProperty.call(e, o)) {
                    var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                    i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                }
        }
        n.default = e, t && t.set(e, n);
        return n
    }(A);

    function Fn() {
        if ("function" != typeof WeakMap) return null;
        var e = new WeakMap;
        return Fn = function () {
            return e
        }, e
    }
    var Ln = {
        methodOrder: ["simulationResume", "mouseOrPen", "hasPointer", "idle"],
        search: function (e) {
            for (var t = 0; t < Ln.methodOrder.length; t++) {
                var n;
                n = Ln.methodOrder[t];
                var r = Ln[n](e);
                if (r) return r
            }
        },
        simulationResume: function (e) {
            var t = e.pointerType,
                n = e.eventType,
                r = e.eventTarget,
                o = e.scope;
            if (!/down|start/i.test(n)) return null;
            for (var i = 0; i < o.interactions.list.length; i++) {
                var a = o.interactions.list[i],
                    s = r;
                if (a.simulation && a.simulation.allowResume && a.pointerType === t)
                    for (; s;) {
                        if (s === a.element) return a;
                        s = Nn.parentNode(s)
                    }
            }
            return null
        },
        mouseOrPen: function (e) {
            var t, n = e.pointerId,
                r = e.pointerType,
                o = e.eventType,
                i = e.scope;
            if ("mouse" !== r && "pen" !== r) return null;
            for (var a = 0; a < i.interactions.list.length; a++) {
                var s = i.interactions.list[a];
                if (s.pointerType === r) {
                    if (s.simulation && !Vn(s, n)) continue;
                    if (s.interacting()) return s;
                    t = t || s
                }
            }
            if (t) return t;
            for (var u = 0; u < i.interactions.list.length; u++) {
                var l = i.interactions.list[u];
                if (!(l.pointerType !== r || /down/i.test(o) && l.simulation)) return l
            }
            return null
        },
        hasPointer: function (e) {
            for (var t = e.pointerId, n = e.scope, r = 0; r < n.interactions.list.length; r++) {
                var o = n.interactions.list[r];
                if (Vn(o, t)) return o
            }
            return null
        },
        idle: function (e) {
            for (var t = e.pointerType, n = e.scope, r = 0; r < n.interactions.list.length; r++) {
                var o = n.interactions.list[r];
                if (1 === o.pointers.length) {
                    var i = o.interactable;
                    if (i && (!i.options.gesture || !i.options.gesture.enabled)) continue
                } else if (2 <= o.pointers.length) continue;
                if (!o.interacting() && t === o.pointerType) return o
            }
            return null
        }
    };

    function Vn(e, t) {
        return e.pointers.some(function (e) {
            return e.id === t
        })
    }
    var qn = Ln;
    Yn.default = qn;
    var Gn = {};
    Object.defineProperty(Gn, "__esModule", {
        value: !0
    }), Gn.default = void 0;
    var Un = h({}),
        Bn = Kn(s),
        Hn = Kn(y);

    function $n() {
        if ("function" != typeof WeakMap) return null;
        var e = new WeakMap;
        return $n = function () {
            return e
        }, e
    }

    function Kn(e) {
        if (e && e.__esModule) return e;
        var t = $n();
        if (t && t.has(e)) return t.get(e);
        var n = {};
        if (null != e) {
            var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
            for (var o in e)
                if (Object.prototype.hasOwnProperty.call(e, o)) {
                    var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                    i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                }
        }
        return n.default = e, t && t.set(e, n), n
    }

    function Qn(e) {
        var t = e.interaction;
        if ("drag" === t.prepared.name) {
            var n = t.prepared.axis;
            "x" === n ? (t.coords.cur.page.y = t.coords.start.page.y, t.coords.cur.client.y = t.coords.start.client.y, t.coords.velocity.client.y = 0, t.coords.velocity.page.y = 0) : "y" === n && (t.coords.cur.page.x = t.coords.start.page.x, t.coords.cur.client.x = t.coords.start.client.x, t.coords.velocity.client.x = 0, t.coords.velocity.page.x = 0)
        }
    }

    function Jn(e) {
        var t = e.iEvent,
            n = e.interaction;
        if ("drag" === n.prepared.name) {
            var r = n.prepared.axis;
            if ("x" === r || "y" === r) {
                var o = "x" === r ? "y" : "x";
                t.page[o] = n.coords.start.page[o], t.client[o] = n.coords.start.client[o], t.delta[o] = 0
            }
        }
    }
    Un.ActionName.Drag = "drag";
    var Zn = {
            id: "actions/drag",
            install: function (e) {
                var t = e.actions,
                    n = e.Interactable,
                    r = e.interactions,
                    o = e.defaults;
                r.signals.on("before-action-move", Qn), r.signals.on("action-resume", Qn), r.signals.on("action-move", Jn), n.prototype.draggable = Zn.draggable, t[Un.ActionName.Drag] = Zn, t.names.push(Un.ActionName.Drag), Bn.merge(t.eventTypes, ["dragstart", "dragmove", "draginertiastart", "dragresume", "dragend"]), t.methodDict.drag = "draggable", o.actions.drag = Zn.defaults
            },
            draggable: function (e) {
                return Hn.object(e) ? (this.options.drag.enabled = !1 !== e.enabled, this.setPerAction("drag", e), this.setOnEvents("drag", e), /^(xy|x|y|start)$/.test(e.lockAxis) && (this.options.drag.lockAxis = e.lockAxis), /^(xy|x|y)$/.test(e.startAxis) && (this.options.drag.startAxis = e.startAxis), this) : Hn.bool(e) ? (this.options.drag.enabled = e, this) : this.options.drag
            },
            beforeMove: Qn,
            move: Jn,
            defaults: {
                startAxis: "xy",
                lockAxis: "xy"
            },
            checker: function (e, t, n) {
                var r = n.options.drag;
                return r.enabled ? {
                    name: "drag",
                    axis: "start" === r.lockAxis ? r.startAxis : r.lockAxis
                } : null
            },
            getCursor: function () {
                return "move"
            }
        },
        er = Zn;
    Gn.default = er;
    var tr = {};
    Object.defineProperty(tr, "__esModule", {
        value: !0
    }), tr.default = void 0;
    var nr, rr = (nr = hn) && nr.__esModule ? nr : {
            default: nr
        },
        or = function (e) {
            if (e && e.__esModule) return e;
            var t = ir();
            if (t && t.has(e)) return t.get(e);
            var n = {};
            if (null != e) {
                var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
                for (var o in e)
                    if (Object.prototype.hasOwnProperty.call(e, o)) {
                        var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                        i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                    }
            }
            n.default = e, t && t.set(e, n);
            return n
        }(s);

    function ir() {
        if ("function" != typeof WeakMap) return null;
        var e = new WeakMap;
        return ir = function () {
            return e
        }, e
    }

    function ar(e) {
        return (ar = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
            return typeof e
        } : function (e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
        })(e)
    }

    function sr(e) {
        return function (e) {
            if (Array.isArray(e)) {
                for (var t = 0, n = new Array(e.length); t < e.length; t++) n[t] = e[t];
                return n
            }
        }(e) || function (e) {
            if (Symbol.iterator in Object(e) || "[object Arguments]" === Object.prototype.toString.call(e)) return Array.from(e)
        }(e) || function () {
            throw new TypeError("Invalid attempt to spread non-iterable instance")
        }()
    }

    function ur(e, t) {
        for (var n = 0; n < t.length; n++) {
            var r = t[n];
            r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
        }
    }

    function lr(e, t) {
        return !t || "object" !== ar(t) && "function" != typeof t ? function (e) {
            if (void 0 !== e) return e;
            throw new ReferenceError("this hasn't been initialised - super() hasn't been called")
        }(e) : t
    }

    function cr(e) {
        return (cr = Object.setPrototypeOf ? Object.getPrototypeOf : function (e) {
            return e.__proto__ || Object.getPrototypeOf(e)
        })(e)
    }

    function fr(e, t) {
        return (fr = Object.setPrototypeOf || function (e, t) {
            return e.__proto__ = t, e
        })(e, t)
    }
    var pr = function () {
        function s(e, t, n) {
            var r;
            ! function (e, t) {
                if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
            }(this, s), (r = lr(this, cr(s).call(this, t._interaction))).propagationStopped = !1, r.immediatePropagationStopped = !1;
            var o = "dragleave" === n ? e.prev : e.cur,
                i = o.element,
                a = o.dropzone;
            return r.type = n, r.target = i, r.currentTarget = i, r.dropzone = a, r.dragEvent = t, r.relatedTarget = t.target, r.draggable = t.interactable, r.timeStamp = t.timeStamp, r
        }
        return function (e, t) {
                if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function");
                e.prototype = Object.create(t && t.prototype, {
                    constructor: {
                        value: e,
                        writable: !0,
                        configurable: !0
                    }
                }), t && fr(e, t)
            }(s, rr["default"]),
            function (e, t, n) {
                t && ur(e.prototype, t), n && ur(e, n)
            }(s, [{
                key: "reject",
                value: function () {
                    var r = this,
                        e = this._interaction.dropState;
                    if ("dropactivate" === this.type || this.dropzone && e.cur.dropzone === this.dropzone && e.cur.element === this.target)
                        if (e.prev.dropzone = this.dropzone, e.prev.element = this.target, e.rejected = !0, e.events.enter = null, this.stopImmediatePropagation(), "dropactivate" === this.type) {
                            var t = e.activeDrops,
                                n = or.findIndex(t, function (e) {
                                    var t = e.dropzone,
                                        n = e.element;
                                    return t === r.dropzone && n === r.target
                                });
                            e.activeDrops = [].concat(sr(t.slice(0, n)), sr(t.slice(n + 1)));
                            var o = new s(e, this.dragEvent, "dropdeactivate");
                            o.dropzone = this.dropzone, o.target = this.target, this.dropzone.fire(o)
                        } else this.dropzone.fire(new s(e, this.dragEvent, "dragleave"))
                }
            }, {
                key: "preventDefault",
                value: function () {}
            }, {
                key: "stopPropagation",
                value: function () {
                    this.propagationStopped = !0
                }
            }, {
                key: "stopImmediatePropagation",
                value: function () {
                    this.immediatePropagationStopped = this.propagationStopped = !0
                }
            }]), s
    }();
    tr.default = pr;
    var dr = {};
    Object.defineProperty(dr, "__esModule", {
        value: !0
    }), dr.default = void 0;
    var vr = function (e) {
            if (e && e.__esModule) return e;
            var t = mr();
            if (t && t.has(e)) return t.get(e);
            var n = {};
            if (null != e) {
                var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
                for (var o in e)
                    if (Object.prototype.hasOwnProperty.call(e, o)) {
                        var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                        i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                    }
            }
            n.default = e, t && t.set(e, n);
            return n
        }(lt),
        gr = yr(Gn),
        hr = yr(tr);

    function yr(e) {
        return e && e.__esModule ? e : {
            default: e
        }
    }

    function mr() {
        if ("function" != typeof WeakMap) return null;
        var e = new WeakMap;
        return mr = function () {
            return e
        }, e
    }

    function br(e, t) {
        for (var n = 0; n < e.length; n++) {
            var r = e[n],
                o = r.dropzone,
                i = r.element;
            t.dropzone = o, t.target = i, o.fire(t), t.propagationStopped = t.immediatePropagationStopped = !1
        }
    }

    function wr(e, t) {
        for (var n = function (e, t) {
                for (var n = e.interactables, r = [], o = 0; o < n.list.length; o++) {
                    var i = n.list[o];
                    if (i.options.drop.enabled) {
                        var a = i.options.drop.accept;
                        if (!(vr.is.element(a) && a !== t || vr.is.string(a) && !vr.dom.matchesSelector(t, a) || vr.is.func(a) && !a({
                                dropzone: i,
                                draggableElement: t
                            })))
                            for (var s = vr.is.string(i.target) ? i._context.querySelectorAll(i.target) : vr.is.array(i.target) ? i.target : [i.target], u = 0; u < s.length; u++) {
                                var l = s[u];
                                l !== t && r.push({
                                    dropzone: i,
                                    element: l
                                })
                            }
                    }
                }
                return r
            }(e, t), r = 0; r < n.length; r++) {
            var o = n[r];
            o.rect = o.dropzone.getRect(o.element)
        }
        return n
    }

    function Or(e, t, n) {
        for (var r = e.dropState, o = e.interactable, i = e.element, a = [], s = 0; s < r.activeDrops.length; s++) {
            var u = r.activeDrops[s],
                l = u.dropzone,
                c = u.element,
                f = u.rect;
            a.push(l.dropCheck(t, n, o, i, c, f) ? c : null)
        }
        var p = vr.dom.indexOfDeepestElement(a);
        return r.activeDrops[p] || null
    }

    function Pr(e, t, n) {
        var r = e.dropState,
            o = {
                enter: null,
                leave: null,
                activate: null,
                deactivate: null,
                move: null,
                drop: null
            };
        return "dragstart" === n.type && (o.activate = new hr.default(r, n, "dropactivate"), o.activate.target = null, o.activate.dropzone = null), "dragend" === n.type && (o.deactivate = new hr.default(r, n, "dropdeactivate"), o.deactivate.target = null, o.deactivate.dropzone = null), r.rejected || (r.cur.element !== r.prev.element && (r.prev.dropzone && (o.leave = new hr.default(r, n, "dragleave"), n.dragLeave = o.leave.target = r.prev.element, n.prevDropzone = o.leave.dropzone = r.prev.dropzone), r.cur.dropzone && (o.enter = new hr.default(r, n, "dragenter"), n.dragEnter = r.cur.element, n.dropzone = r.cur.dropzone)), "dragend" === n.type && r.cur.dropzone && (o.drop = new hr.default(r, n, "drop"), n.dropzone = r.cur.dropzone, n.relatedTarget = r.cur.element), "dragmove" === n.type && r.cur.dropzone && (o.move = new hr.default(r, n, "dropmove"), (o.move.dragmove = n).dropzone = r.cur.dropzone)), o
    }

    function _r(e, t) {
        var n = e.dropState,
            r = n.activeDrops,
            o = n.cur,
            i = n.prev;
        t.leave && i.dropzone.fire(t.leave), t.move && o.dropzone.fire(t.move), t.enter && o.dropzone.fire(t.enter), t.drop && o.dropzone.fire(t.drop), t.deactivate && br(r, t.deactivate), n.prev.dropzone = o.dropzone, n.prev.element = o.element
    }

    function xr(e, t) {
        var n = e.interaction,
            r = e.iEvent,
            o = e.event;
        if ("dragmove" === r.type || "dragend" === r.type) {
            var i = n.dropState;
            t.dynamicDrop && (i.activeDrops = wr(t, n.element));
            var a = r,
                s = Or(n, a, o);
            i.rejected = i.rejected && !!s && s.dropzone === i.cur.dropzone && s.element === i.cur.element, i.cur.dropzone = s && s.dropzone, i.cur.element = s && s.element, i.events = Pr(n, 0, a)
        }
    }
    var jr = {
            id: "actions/drop",
            install: function (i) {
                var e = i.actions,
                    t = i.interact,
                    n = i.Interactable,
                    r = i.interactions,
                    o = i.defaults;
                i.usePlugin(gr.default), r.signals.on("before-action-start", function (e) {
                    var t = e.interaction;
                    "drag" === t.prepared.name && (t.dropState = {
                        cur: {
                            dropzone: null,
                            element: null
                        },
                        prev: {
                            dropzone: null,
                            element: null
                        },
                        rejected: null,
                        events: null,
                        activeDrops: null
                    })
                }), r.signals.on("after-action-start", function (e) {
                    var t = e.interaction,
                        n = e.event,
                        r = e.iEvent;
                    if ("drag" === t.prepared.name) {
                        var o = t.dropState;
                        o.activeDrops = null, o.events = null, o.activeDrops = wr(i, t.element), o.events = Pr(t, n, r), o.events.activate && br(o.activeDrops, o.events.activate)
                    }
                }), r.signals.on("action-move", function (e) {
                    return xr(e, i)
                }), r.signals.on("action-end", function (e) {
                    return xr(e, i)
                }), r.signals.on("after-action-move", function (e) {
                    var t = e.interaction;
                    "drag" === t.prepared.name && (_r(t, t.dropState.events), t.dropState.events = {})
                }), r.signals.on("after-action-end", function (e) {
                    var t = e.interaction;
                    "drag" === t.prepared.name && _r(t, t.dropState.events)
                }), r.signals.on("stop", function (e) {
                    var t = e.interaction;
                    if ("drag" === t.prepared.name) {
                        var n = t.dropState;
                        n && (n.activeDrops = null, n.events = null, n.cur.dropzone = null, n.cur.element = null, n.prev.dropzone = null, n.prev.element = null, n.rejected = !1)
                    }
                }), n.prototype.dropzone = function (e) {
                    return function (e, t) {
                        if (vr.is.object(t)) {
                            if (e.options.drop.enabled = !1 !== t.enabled, t.listeners) {
                                var n = vr.normalizeListeners(t.listeners),
                                    r = Object.keys(n).reduce(function (e, t) {
                                        return e[/^(enter|leave)/.test(t) ? "drag".concat(t) : /^(activate|deactivate|move)/.test(t) ? "drop".concat(t) : t] = n[t], e
                                    }, {});
                                e.off(e.options.drop.listeners), e.on(r), e.options.drop.listeners = r
                            }
                            return vr.is.func(t.ondrop) && e.on("drop", t.ondrop), vr.is.func(t.ondropactivate) && e.on("dropactivate", t.ondropactivate), vr.is.func(t.ondropdeactivate) && e.on("dropdeactivate", t.ondropdeactivate), vr.is.func(t.ondragenter) && e.on("dragenter", t.ondragenter), vr.is.func(t.ondragleave) && e.on("dragleave", t.ondragleave), vr.is.func(t.ondropmove) && e.on("dropmove", t.ondropmove), /^(pointer|center)$/.test(t.overlap) ? e.options.drop.overlap = t.overlap : vr.is.number(t.overlap) && (e.options.drop.overlap = Math.max(Math.min(1, t.overlap), 0)), "accept" in t && (e.options.drop.accept = t.accept), "checker" in t && (e.options.drop.checker = t.checker), e
                        }
                        if (vr.is.bool(t)) return e.options.drop.enabled = t, e;
                        return e.options.drop
                    }(this, e)
                }, n.prototype.dropCheck = function (e, t, n, r, o, i) {
                    return function (e, t, n, r, o, i, a) {
                        var s = !1;
                        if (!(a = a || e.getRect(i))) return !!e.options.drop.checker && e.options.drop.checker(t, n, s, e, i, r, o);
                        var u = e.options.drop.overlap;
                        if ("pointer" === u) {
                            var l = vr.getOriginXY(r, o, "drag"),
                                c = vr.pointer.getPageXY(t);
                            c.x += l.x, c.y += l.y;
                            var f = c.x > a.left && c.x < a.right,
                                p = c.y > a.top && c.y < a.bottom;
                            s = f && p
                        }
                        var d = r.getRect(o);
                        if (d && "center" === u) {
                            var v = d.left + d.width / 2,
                                g = d.top + d.height / 2;
                            s = v >= a.left && v <= a.right && g >= a.top && g <= a.bottom
                        }
                        if (d && vr.is.number(u)) {
                            var h = Math.max(0, Math.min(a.right, d.right) - Math.max(a.left, d.left)) * Math.max(0, Math.min(a.bottom, d.bottom) - Math.max(a.top, d.top)) / (d.width * d.height);
                            s = u <= h
                        }
                        e.options.drop.checker && (s = e.options.drop.checker(t, n, s, e, i, r, o));
                        return s
                    }(this, e, t, n, r, o, i)
                }, t.dynamicDrop = function (e) {
                    return vr.is.bool(e) ? (i.dynamicDrop = e, t) : i.dynamicDrop
                }, vr.arr.merge(e.eventTypes, ["dragenter", "dragleave", "dropactivate", "dropdeactivate", "dropmove", "drop"]), e.methodDict.drop = "dropzone", i.dynamicDrop = !1, o.actions.drop = jr.defaults
            },
            getActiveDrops: wr,
            getDrop: Or,
            getDropEvents: Pr,
            fireDropEvents: _r,
            defaults: {
                enabled: !1,
                accept: null,
                overlap: "pointer"
            }
        },
        Mr = jr;
    dr.default = Mr;
    var Er = {};
    Object.defineProperty(Er, "__esModule", {
        value: !0
    }), Er.default = void 0;
    var Sr, kr = (Sr = wn) && Sr.__esModule ? Sr : {
            default: Sr
        },
        Tr = h({}),
        Dr = function (e) {
            if (e && e.__esModule) return e;
            var t = Ir();
            if (t && t.has(e)) return t.get(e);
            var n = {};
            if (null != e) {
                var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
                for (var o in e)
                    if (Object.prototype.hasOwnProperty.call(e, o)) {
                        var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                        i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                    }
            }
            n.default = e, t && t.set(e, n);
            return n
        }(lt);

    function Ir() {
        if ("function" != typeof WeakMap) return null;
        var e = new WeakMap;
        return Ir = function () {
            return e
        }, e
    }
    Tr.ActionName.Gesture = "gesture";
    var zr = {
        id: "actions/gesture",
        install: function (e) {
            var t = e.actions,
                n = e.Interactable,
                r = e.interactions,
                o = e.defaults;
            n.prototype.gesturable = function (e) {
                return Dr.is.object(e) ? (this.options.gesture.enabled = !1 !== e.enabled, this.setPerAction("gesture", e), this.setOnEvents("gesture", e), this) : Dr.is.bool(e) ? (this.options.gesture.enabled = e, this) : this.options.gesture
            }, r.signals.on("action-start", Ar), r.signals.on("action-move", Ar), r.signals.on("action-end", Ar), r.signals.on("new", function (e) {
                e.interaction.gesture = {
                    angle: 0,
                    distance: 0,
                    scale: 1,
                    startAngle: 0,
                    startDistance: 0
                }
            }), t[Tr.ActionName.Gesture] = zr, t.names.push(Tr.ActionName.Gesture), Dr.arr.merge(t.eventTypes, ["gesturestart", "gesturemove", "gestureend"]), t.methodDict.gesture = "gesturable", o.actions.gesture = zr.defaults
        },
        defaults: {},
        checker: function (e, t, n, r, o) {
            return 2 <= o.pointers.length ? {
                name: "gesture"
            } : null
        },
        getCursor: function () {
            return ""
        }
    };

    function Ar(e) {
        var t = e.interaction,
            n = e.iEvent,
            r = e.event,
            o = e.phase;
        if ("gesture" === t.prepared.name) {
            var i = t.pointers.map(function (e) {
                    return e.pointer
                }),
                a = "start" === o,
                s = "end" === o,
                u = t.interactable.options.deltaSource;
            if (n.touches = [i[0], i[1]], a) n.distance = Dr.pointer.touchDistance(i, u), n.box = Dr.pointer.touchBBox(i), n.scale = 1, n.ds = 0, n.angle = Dr.pointer.touchAngle(i, u), n.da = 0, t.gesture.startDistance = n.distance, t.gesture.startAngle = n.angle;
            else if (s || r instanceof kr.default) {
                var l = t.prevEvent;
                n.distance = l.distance, n.box = l.box, n.scale = l.scale, n.ds = 0, n.angle = l.angle, n.da = 0
            } else n.distance = Dr.pointer.touchDistance(i, u), n.box = Dr.pointer.touchBBox(i), n.scale = n.distance / t.gesture.startDistance, n.angle = Dr.pointer.touchAngle(i, u), n.ds = n.scale - t.gesture.scale, n.da = n.angle - t.gesture.angle;
            t.gesture.distance = n.distance, t.gesture.angle = n.angle, Dr.is.number(n.scale) && n.scale !== 1 / 0 && !isNaN(n.scale) && (t.gesture.scale = n.scale)
        }
    }
    var Cr = zr;
    Er.default = Cr;
    var Rr = {};
    Object.defineProperty(Rr, "__esModule", {
        value: !0
    }), Rr.default = void 0;
    var Wr, Xr = h({}),
        Yr = qr(s),
        Nr = qr(A),
        Fr = (Wr = Ce) && Wr.__esModule ? Wr : {
            default: Wr
        },
        Lr = qr(y);

    function Vr() {
        if ("function" != typeof WeakMap) return null;
        var e = new WeakMap;
        return Vr = function () {
            return e
        }, e
    }

    function qr(e) {
        if (e && e.__esModule) return e;
        var t = Vr();
        if (t && t.has(e)) return t.get(e);
        var n = {};
        if (null != e) {
            var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
            for (var o in e)
                if (Object.prototype.hasOwnProperty.call(e, o)) {
                    var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                    i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                }
        }
        return n.default = e, t && t.set(e, n), n
    }
    var Gr = {
        id: "actions/resize",
        install: function (t) {
            var e = t.actions,
                n = t.browser,
                r = t.Interactable,
                o = t.interactions,
                i = t.defaults;
            o.signals.on("new", function (e) {
                e.resizeAxes = "xy"
            }), o.signals.on("action-start", Br), o.signals.on("action-move", Hr), o.signals.on("action-end", $r), o.signals.on("action-start", Kr), o.signals.on("action-move", Kr), Gr.cursors = function (e) {
                return e.isIe9 ? {
                    x: "e-resize",
                    y: "s-resize",
                    xy: "se-resize",
                    top: "n-resize",
                    left: "w-resize",
                    bottom: "s-resize",
                    right: "e-resize",
                    topleft: "se-resize",
                    bottomright: "se-resize",
                    topright: "ne-resize",
                    bottomleft: "ne-resize"
                } : {
                    x: "ew-resize",
                    y: "ns-resize",
                    xy: "nwse-resize",
                    top: "ns-resize",
                    left: "ew-resize",
                    bottom: "ns-resize",
                    right: "ew-resize",
                    topleft: "nwse-resize",
                    bottomright: "nwse-resize",
                    topright: "nesw-resize",
                    bottomleft: "nesw-resize"
                }
            }(n), Gr.defaultMargin = n.supportsTouch || n.supportsPointerEvent ? 20 : 10, r.prototype.resizable = function (e) {
                return function (e, t, n) {
                    if (Lr.object(t)) return e.options.resize.enabled = !1 !== t.enabled, e.setPerAction("resize", t), e.setOnEvents("resize", t), Lr.string(t.axis) && /^x$|^y$|^xy$/.test(t.axis) ? e.options.resize.axis = t.axis : null === t.axis && (e.options.resize.axis = n.defaults.actions.resize.axis), Lr.bool(t.preserveAspectRatio) ? e.options.resize.preserveAspectRatio = t.preserveAspectRatio : Lr.bool(t.square) && (e.options.resize.square = t.square), e;
                    if (Lr.bool(t)) return e.options.resize.enabled = t, e;
                    return e.options.resize
                }(this, e, t)
            }, e[Xr.ActionName.Resize] = Gr, e.names.push(Xr.ActionName.Resize), Yr.merge(e.eventTypes, ["resizestart", "resizemove", "resizeinertiastart", "resizeresume", "resizeend"]), e.methodDict.resize = "resizable", i.actions.resize = Gr.defaults
        },
        defaults: {
            square: !(Xr.ActionName.Resize = "resize"),
            preserveAspectRatio: !1,
            axis: "xy",
            margin: NaN,
            edges: null,
            invert: "none"
        },
        checker: function (e, t, n, r, o, i) {
            if (!i) return null;
            var a = (0, Fr.default)({}, o.coords.cur.page),
                s = n.options;
            if (s.resize.enabled) {
                var u = s.resize,
                    l = {
                        left: !1,
                        right: !1,
                        top: !1,
                        bottom: !1
                    };
                if (Lr.object(u.edges)) {
                    for (var c in l) l[c] = Ur(c, u.edges[c], a, o._latestPointer.eventTarget, r, i, u.margin || this.defaultMargin);
                    if (l.left = l.left && !l.right, l.top = l.top && !l.bottom, l.left || l.right || l.top || l.bottom) return {
                        name: "resize",
                        edges: l
                    }
                } else {
                    var f = "y" !== s.resize.axis && a.x > i.right - this.defaultMargin,
                        p = "x" !== s.resize.axis && a.y > i.bottom - this.defaultMargin;
                    if (f || p) return {
                        name: "resize",
                        axes: (f ? "x" : "") + (p ? "y" : "")
                    }
                }
            }
            return null
        },
        cursors: null,
        getCursor: function (e) {
            var t = e.edges,
                n = e.axis,
                r = e.name,
                o = Gr.cursors,
                i = null;
            if (n) i = o[r + n];
            else if (t) {
                for (var a = "", s = ["top", "bottom", "left", "right"], u = 0; u < s.length; u++) {
                    var l = s[u];
                    t[l] && (a += l)
                }
                i = o[a]
            }
            return i
        },
        defaultMargin: null
    };

    function Ur(e, t, n, r, o, i, a) {
        if (!t) return !1;
        if (!0 === t) {
            var s = Lr.number(i.width) ? i.width : i.right - i.left,
                u = Lr.number(i.height) ? i.height : i.bottom - i.top;
            if (a = Math.min(a, ("left" === e || "right" === e ? s : u) / 2), s < 0 && ("left" === e ? e = "right" : "right" === e && (e = "left")), u < 0 && ("top" === e ? e = "bottom" : "bottom" === e && (e = "top")), "left" === e) return n.x < (0 <= s ? i.left : i.right) + a;
            if ("top" === e) return n.y < (0 <= u ? i.top : i.bottom) + a;
            if ("right" === e) return n.x > (0 <= s ? i.right : i.left) - a;
            if ("bottom" === e) return n.y > (0 <= u ? i.bottom : i.top) - a
        }
        return !!Lr.element(r) && (Lr.element(t) ? t === r : Nr.matchesUpTo(r, t, o))
    }

    function Br(e) {
        var t = e.iEvent,
            n = e.interaction;
        if ("resize" === n.prepared.name && n.prepared.edges) {
            var r = (0, Fr.default)({}, n.rect),
                o = n.interactable.options.resize;
            if (o.square || o.preserveAspectRatio) {
                var i = (0, Fr.default)({}, n.prepared.edges);
                i.top = i.top || i.left && !i.bottom, i.left = i.left || i.top && !i.right, i.bottom = i.bottom || i.right && !i.top, i.right = i.right || i.bottom && !i.left, n.prepared._linkedEdges = i
            } else n.prepared._linkedEdges = null;
            o.preserveAspectRatio && (n.resizeStartAspectRatio = r.width / r.height), n.resizeRects = {
                start: r,
                current: {
                    left: r.left,
                    right: r.right,
                    top: r.top,
                    bottom: r.bottom
                },
                inverted: (0, Fr.default)({}, r),
                previous: (0, Fr.default)({}, r),
                delta: {
                    left: 0,
                    right: 0,
                    width: 0,
                    top: 0,
                    bottom: 0,
                    height: 0
                }
            }, t.edges = n.prepared.edges, t.rect = n.resizeRects.inverted, t.deltaRect = n.resizeRects.delta
        }
    }

    function Hr(e) {
        var t = e.iEvent,
            n = e.interaction;
        if ("resize" === n.prepared.name && n.prepared.edges) {
            var r, o = n.interactable.options.resize,
                i = o.invert,
                a = "reposition" === i || "negate" === i,
                s = n.prepared.edges,
                u = n.resizeRects.start,
                l = n.resizeRects.current,
                c = n.resizeRects.inverted,
                f = n.resizeRects.delta,
                p = (0, Fr.default)(n.resizeRects.previous, c),
                d = s,
                v = (0, Fr.default)({}, t.delta);
            if (o.preserveAspectRatio || o.square) {
                var g = o.preserveAspectRatio ? n.resizeStartAspectRatio : 1;
                s = n.prepared._linkedEdges, d.left && d.bottom || d.right && d.top ? v.y = -v.x / g : d.left || d.right ? v.y = v.x / g : (d.top || d.bottom) && (v.x = v.y * g)
            }
            if (s.top && (l.top += v.y), s.bottom && (l.bottom += v.y), s.left && (l.left += v.x), s.right && (l.right += v.x), a) {
                if ((0, Fr.default)(c, l), "reposition" === i) c.top > c.bottom && (r = c.top, c.top = c.bottom, c.bottom = r), c.left > c.right && (r = c.left, c.left = c.right, c.right = r)
            } else c.top = Math.min(l.top, u.bottom), c.bottom = Math.max(l.bottom, u.top), c.left = Math.min(l.left, u.right), c.right = Math.max(l.right, u.left);
            for (var h in c.width = c.right - c.left, c.height = c.bottom - c.top, c) f[h] = c[h] - p[h];
            t.edges = n.prepared.edges, t.rect = c, t.deltaRect = f
        }
    }

    function $r(e) {
        var t = e.iEvent,
            n = e.interaction;
        "resize" === n.prepared.name && n.prepared.edges && (t.edges = n.prepared.edges, t.rect = n.resizeRects.inverted, t.deltaRect = n.resizeRects.delta)
    }

    function Kr(e) {
        var t = e.iEvent,
            n = e.interaction;
        e.action === Xr.ActionName.Resize && n.resizeAxes && (n.interactable.options.resize.square ? ("y" === n.resizeAxes ? t.delta.x = t.delta.y : t.delta.y = t.delta.x, t.axes = "xy") : (t.axes = n.resizeAxes, "x" === n.resizeAxes ? t.delta.y = 0 : "y" === n.resizeAxes && (t.delta.x = 0)))
    }
    var Qr = Gr;
    Rr.default = Qr;
    var Jr = {};
    Object.defineProperty(Jr, "__esModule", {
        value: !0
    }), Jr.install = function (e) {
        e.usePlugin(to.default), e.usePlugin(no.default), e.usePlugin(Zr.default), e.usePlugin(eo.default)
    }, Object.defineProperty(Jr, "drag", {
        enumerable: !0,
        get: function () {
            return Zr.default
        }
    }), Object.defineProperty(Jr, "drop", {
        enumerable: !0,
        get: function () {
            return eo.default
        }
    }), Object.defineProperty(Jr, "gesture", {
        enumerable: !0,
        get: function () {
            return to.default
        }
    }), Object.defineProperty(Jr, "resize", {
        enumerable: !0,
        get: function () {
            return no.default
        }
    }), Jr.id = void 0;
    var Zr = ro(Gn),
        eo = ro(dr),
        to = ro(Er),
        no = ro(Rr);

    function ro(e) {
        return e && e.__esModule ? e : {
            default: e
        }
    }
    Jr.id = "actions";
    var oo = {};
    Object.defineProperty(oo, "__esModule", {
        value: !0
    }), oo.getContainer = po, oo.getScroll = vo, oo.getScrollSize = function (e) {
        so.window(e) && (e = window.document.body);
        return {
            x: e.scrollWidth,
            y: e.scrollHeight
        }
    }, oo.getScrollSizeDelta = function (e, t) {
        var n = e.interaction,
            r = e.element,
            o = n && n.interactable.options[n.prepared.name].autoScroll;
        if (!o || !o.enabled) return t(), {
            x: 0,
            y: 0
        };
        var i = po(o.container, n.interactable, r),
            a = vo(i);
        t();
        var s = vo(i);
        return {
            x: s.x - a.x,
            y: s.y - a.y
        }
    }, oo.default = void 0;
    var io, ao = co(A),
        so = co(y),
        uo = (io = tt) && io.__esModule ? io : {
            default: io
        };

    function lo() {
        if ("function" != typeof WeakMap) return null;
        var e = new WeakMap;
        return lo = function () {
            return e
        }, e
    }

    function co(e) {
        if (e && e.__esModule) return e;
        var t = lo();
        if (t && t.has(e)) return t.get(e);
        var n = {};
        if (null != e) {
            var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
            for (var o in e)
                if (Object.prototype.hasOwnProperty.call(e, o)) {
                    var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                    i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                }
        }
        return n.default = e, t && t.set(e, n), n
    }
    var fo = {
        defaults: {
            enabled: !1,
            margin: 60,
            container: null,
            speed: 300
        },
        now: Date.now,
        interaction: null,
        i: null,
        x: 0,
        y: 0,
        isScrolling: !1,
        prevTime: 0,
        margin: 0,
        speed: 0,
        start: function (e) {
            fo.isScrolling = !0, uo.default.cancel(fo.i), (e.autoScroll = fo).interaction = e, fo.prevTime = fo.now(), fo.i = uo.default.request(fo.scroll)
        },
        stop: function () {
            fo.isScrolling = !1, fo.interaction && (fo.interaction.autoScroll = null), uo.default.cancel(fo.i)
        },
        scroll: function () {
            var e = fo.interaction,
                t = e.interactable,
                n = e.element,
                r = t.options[fo.interaction.prepared.name].autoScroll,
                o = po(r.container, t, n),
                i = fo.now(),
                a = (i - fo.prevTime) / 1e3,
                s = r.speed * a;
            if (1 <= s) {
                var u = {
                    x: fo.x * s,
                    y: fo.y * s
                };
                if (u.x || u.y) {
                    var l = vo(o);
                    so.window(o) ? o.scrollBy(u.x, u.y) : o && (o.scrollLeft += u.x, o.scrollTop += u.y);
                    var c = vo(o),
                        f = {
                            x: c.x - l.x,
                            y: c.y - l.y
                        };
                    (f.x || f.y) && t.fire({
                        type: "autoscroll",
                        target: n,
                        interactable: t,
                        delta: f,
                        interaction: e,
                        container: o
                    })
                }
                fo.prevTime = i
            }
            fo.isScrolling && (uo.default.cancel(fo.i), fo.i = uo.default.request(fo.scroll))
        },
        check: function (e, t) {
            var n = e.options;
            return n[t].autoScroll && n[t].autoScroll.enabled
        },
        onInteractionMove: function (e) {
            var t = e.interaction,
                n = e.pointer;
            if (t.interacting() && fo.check(t.interactable, t.prepared.name))
                if (t.simulation) fo.x = fo.y = 0;
                else {
                    var r, o, i, a, s = t.interactable,
                        u = t.element,
                        l = s.options[t.prepared.name].autoScroll,
                        c = po(l.container, s, u);
                    if (so.window(c)) a = n.clientX < fo.margin, r = n.clientY < fo.margin, o = n.clientX > c.innerWidth - fo.margin, i = n.clientY > c.innerHeight - fo.margin;
                    else {
                        var f = ao.getElementClientRect(c);
                        a = n.clientX < f.left + fo.margin, r = n.clientY < f.top + fo.margin, o = n.clientX > f.right - fo.margin, i = n.clientY > f.bottom - fo.margin
                    }
                    fo.x = o ? 1 : a ? -1 : 0, fo.y = i ? 1 : r ? -1 : 0, fo.isScrolling || (fo.margin = l.margin, fo.speed = l.speed, fo.start(t))
                }
        }
    };

    function po(e, t, n) {
        return (so.string(e) ? (0, Re.getStringOptionResult)(e, t, n) : e) || (0, l.getWindow)(n)
    }

    function vo(e) {
        return so.window(e) && (e = window.document.body), {
            x: e.scrollLeft,
            y: e.scrollTop
        }
    }
    var go = {
        id: "auto-scroll",
        install: function (e) {
            var t = e.interactions,
                n = e.defaults,
                r = e.actions;
            (e.autoScroll = fo).now = function () {
                return e.now()
            }, t.signals.on("new", function (e) {
                e.interaction.autoScroll = null
            }), t.signals.on("destroy", function (e) {
                e.interaction.autoScroll = null, fo.stop(), fo.interaction && (fo.interaction = null)
            }), t.signals.on("stop", fo.stop), t.signals.on("action-move", function (e) {
                return fo.onInteractionMove(e)
            }), r.eventTypes.push("autoscroll"), n.perAction.autoScroll = fo.defaults
        }
    };
    oo.default = go;
    var ho = {};
    Object.defineProperty(ho, "__esModule", {
        value: !0
    }), ho.default = void 0;
    var yo = function (e) {
        if (e && e.__esModule) return e;
        var t = mo();
        if (t && t.has(e)) return t.get(e);
        var n = {};
        if (null != e) {
            var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
            for (var o in e)
                if (Object.prototype.hasOwnProperty.call(e, o)) {
                    var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                    i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                }
        }
        n.default = e, t && t.set(e, n);
        return n
    }(y);

    function mo() {
        if ("function" != typeof WeakMap) return null;
        var e = new WeakMap;
        return mo = function () {
            return e
        }, e
    }

    function bo(e, t, n, r) {
        var o = this.defaultActionChecker(e, t, n, r);
        return this.options.actionChecker ? this.options.actionChecker(e, t, o, this, r, n) : o
    }

    function wo(e) {
        return yo.bool(e) ? (this.options.styleCursor = e, this) : null === e ? (delete this.options.styleCursor, this) : this.options.styleCursor
    }

    function Oo(e) {
        return yo.func(e) ? (this.options.actionChecker = e, this) : null === e ? (delete this.options.actionChecker, this) : this.options.actionChecker
    }
    var Po = {
        id: "auto-start/interactableMethods",
        install: function (e) {
            var t = e.Interactable,
                o = e.actions;
            t.prototype.getAction = bo, t.prototype.ignoreFrom = (0, lt.warnOnce)(function (e) {
                return this._backCompatOption("ignoreFrom", e)
            }, "Interactable.ignoreFrom() has been deprecated. Use Interactble.draggable({ignoreFrom: newValue})."), t.prototype.allowFrom = (0, lt.warnOnce)(function (e) {
                return this._backCompatOption("allowFrom", e)
            }, "Interactable.allowFrom() has been deprecated. Use Interactble.draggable({allowFrom: newValue})."), t.prototype.actionChecker = Oo, t.prototype.styleCursor = wo, t.prototype.defaultActionChecker = function (e, t, n, r) {
                return function (e, t, n, r, o, i) {
                    for (var a = e.getRect(o), s = n.buttons || {
                            0: 1,
                            1: 4,
                            3: 8,
                            4: 16
                        } [n.button], u = null, l = 0; l < i.names.length; l++) {
                        var c = i.names[l];
                        if ((!r.pointerIsDown || !/mouse|pointer/.test(r.pointerType) || 0 != (s & e.options[c].mouseButtons)) && (u = i[c].checker(t, n, e, o, r, a))) return u
                    }
                }(this, e, t, n, r, o)
            }
        }
    };
    ho.default = Po;
    var _o = {};
    Object.defineProperty(_o, "__esModule", {
        value: !0
    }), _o.default = void 0;
    var xo, jo = function (e) {
            if (e && e.__esModule) return e;
            var t = Eo();
            if (t && t.has(e)) return t.get(e);
            var n = {};
            if (null != e) {
                var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
                for (var o in e)
                    if (Object.prototype.hasOwnProperty.call(e, o)) {
                        var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                        i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                    }
            }
            n.default = e, t && t.set(e, n);
            return n
        }(lt),
        Mo = (xo = ho) && xo.__esModule ? xo : {
            default: xo
        };

    function Eo() {
        if ("function" != typeof WeakMap) return null;
        var e = new WeakMap;
        return Eo = function () {
            return e
        }, e
    }

    function So(e, t, n, r, o) {
        return t.testIgnoreAllow(t.options[e.name], n, r) && t.options[e.name].enabled && Io(t, n, e, o) ? e : null
    }

    function ko(e, t, n, r, o, i, a) {
        for (var s = 0, u = r.length; s < u; s++) {
            var l = r[s],
                c = o[s],
                f = l.getAction(t, n, e, c);
            if (f) {
                var p = So(f, l, c, i, a);
                if (p) return {
                    action: p,
                    interactable: l,
                    element: c
                }
            }
        }
        return {
            action: null,
            interactable: null,
            element: null
        }
    }

    function To(e, t, n, r, o) {
        var i = [],
            a = [],
            s = r;

        function u(e) {
            i.push(e), a.push(s)
        }
        for (; jo.is.element(s);) {
            i = [], a = [], o.interactables.forEachMatch(s, u);
            var l = ko(e, t, n, i, a, r, o);
            if (l.action && !l.interactable.options[l.action.name].manualStart) return l;
            s = jo.dom.parentNode(s)
        }
        return {
            action: null,
            interactable: null,
            element: null
        }
    }

    function Do(e, t, n) {
        var r = t.action,
            o = t.interactable,
            i = t.element;
        r = r || {
            name: null
        }, e.interactable && e.interactable.options.styleCursor && Ao(e.element, "", n), e.interactable = o, e.element = i, jo.copyAction(e.prepared, r), e.rect = o && r.name ? o.getRect(i) : null, Co(e, n), n.autoStart.signals.fire("prepared", {
            interaction: e
        })
    }

    function Io(e, t, n, r) {
        var o = e.options,
            i = o[n.name].max,
            a = o[n.name].maxPerElement,
            s = r.autoStart.maxInteractions,
            u = 0,
            l = 0,
            c = 0;
        if (!(i && a && s)) return !1;
        for (var f = 0; f < r.interactions.list.length; f++) {
            var p = r.interactions.list[f],
                d = p.prepared.name;
            if (p.interacting()) {
                if (s <= ++u) return !1;
                if (p.interactable === e) {
                    if (i <= (l += d === n.name ? 1 : 0)) return !1;
                    if (p.element === t && (c++, d === n.name && a <= c)) return !1
                }
            }
        }
        return 0 < s
    }

    function zo(e, t) {
        return jo.is.number(e) ? (t.autoStart.maxInteractions = e, this) : t.autoStart.maxInteractions
    }

    function Ao(e, t, n) {
        n.autoStart.cursorElement && (n.autoStart.cursorElement.style.cursor = ""), e.ownerDocument.documentElement.style.cursor = t, e.style.cursor = t, n.autoStart.cursorElement = t ? e : null
    }

    function Co(e, t) {
        var n = e.interactable,
            r = e.element,
            o = e.prepared;
        if ("mouse" === e.pointerType && n && n.options.styleCursor) {
            var i = "";
            if (o.name) {
                var a = n.options[o.name].cursorChecker;
                i = jo.is.func(a) ? a(o, n, r, e._interacting) : t.actions[o.name].getCursor(o)
            }
            Ao(e.element, i || "", t)
        }
    }
    var Ro = {
        id: "auto-start/base",
        install: function (i) {
            var e = i.interact,
                t = i.interactions,
                n = i.defaults;
            i.usePlugin(Mo.default), t.signals.on("down", function (e) {
                var t = e.interaction,
                    n = e.pointer,
                    r = e.event,
                    o = e.eventTarget;
                t.interacting() || Do(t, To(t, n, r, o, i), i)
            }), t.signals.on("move", function (e) {
                var t = e.interaction,
                    n = e.pointer,
                    r = e.event,
                    o = e.eventTarget;
                "mouse" !== t.pointerType || t.pointerIsDown || t.interacting() || Do(t, To(t, n, r, o, i), i)
            }), t.signals.on("move", function (e) {
                var t = e.interaction;
                if (t.pointerIsDown && !t.interacting() && t.pointerWasMoved && t.prepared.name) {
                    i.autoStart.signals.fire("before-start", e);
                    var n = t.interactable;
                    t.prepared.name && n && (n.options[t.prepared.name].manualStart || !Io(n, t.element, t.prepared, i) ? t.stop() : (t.start(t.prepared, n, t.element), Co(t, i)))
                }
            }), t.signals.on("stop", function (e) {
                var t = e.interaction,
                    n = t.interactable;
                n && n.options.styleCursor && Ao(t.element, "", i)
            }), n.base.actionChecker = null, n.base.styleCursor = !0, jo.extend(n.perAction, {
                manualStart: !1,
                max: 1 / 0,
                maxPerElement: 1,
                allowFrom: null,
                ignoreFrom: null,
                mouseButtons: 1
            }), e.maxInteractions = function (e) {
                return zo(e, i)
            }, i.autoStart = {
                maxInteractions: 1 / 0,
                withinInteractionLimit: Io,
                cursorElement: null,
                signals: new jo.Signals
            }
        },
        maxInteractions: zo,
        withinInteractionLimit: Io,
        validateAction: So
    };
    _o.default = Ro;
    var Wo = {};
    Object.defineProperty(Wo, "__esModule", {
        value: !0
    }), Wo.default = void 0;
    var Xo, Yo = h({}),
        No = function (e) {
            if (e && e.__esModule) return e;
            var t = Lo();
            if (t && t.has(e)) return t.get(e);
            var n = {};
            if (null != e) {
                var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
                for (var o in e)
                    if (Object.prototype.hasOwnProperty.call(e, o)) {
                        var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                        i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                    }
            }
            n.default = e, t && t.set(e, n);
            return n
        }(y),
        Fo = (Xo = _o) && Xo.__esModule ? Xo : {
            default: Xo
        };

    function Lo() {
        if ("function" != typeof WeakMap) return null;
        var e = new WeakMap;
        return Lo = function () {
            return e
        }, e
    }
    var Vo = {
        id: "auto-start/dragAxis",
        install: function (d) {
            d.autoStart.signals.on("before-start", function (e) {
                var r = e.interaction,
                    o = e.eventTarget,
                    t = e.dx,
                    n = e.dy;
                if ("drag" === r.prepared.name) {
                    var i = Math.abs(t),
                        a = Math.abs(n),
                        s = r.interactable.options.drag,
                        u = s.startAxis,
                        l = a < i ? "x" : i < a ? "y" : "xy";
                    if (r.prepared.axis = "start" === s.lockAxis ? l[0] : s.lockAxis, "xy" != l && "xy" !== u && u !== l) {
                        r.prepared.name = null;

                        function c(e) {
                            if (e !== r.interactable) {
                                var t = r.interactable.options.drag;
                                if (!t.manualStart && e.testIgnoreAllow(t, f, o)) {
                                    var n = e.getAction(r.downPointer, r.downEvent, r, f);
                                    if (n && n.name === Yo.ActionName.Drag && function (e, t) {
                                            if (!t) return !1;
                                            var n = t.options[Yo.ActionName.Drag].startAxis;
                                            return "xy" === e || "xy" === n || n === e
                                        }(l, e) && Fo.default.validateAction(n, e, f, o, d)) return e
                                }
                            }
                        }
                        for (var f = o; No.element(f);) {
                            var p = d.interactables.forEachMatch(f, c);
                            if (p) {
                                r.prepared.name = Yo.ActionName.Drag, r.interactable = p, r.element = f;
                                break
                            }
                            f = (0, A.parentNode)(f)
                        }
                    }
                }
            })
        }
    };
    Wo.default = Vo;
    var qo = {};
    Object.defineProperty(qo, "__esModule", {
        value: !0
    }), qo.default = void 0;
    var Go, Uo = (Go = _o) && Go.__esModule ? Go : {
        default: Go
    };

    function Bo(e) {
        var t = e.prepared && e.prepared.name;
        if (!t) return null;
        var n = e.interactable.options;
        return n[t].hold || n[t].delay
    }
    var Ho = {
        id: "auto-start/hold",
        install: function (e) {
            var t = e.autoStart,
                n = e.interactions,
                r = e.defaults;
            e.usePlugin(Uo.default), r.perAction.hold = 0, r.perAction.delay = 0, n.signals.on("new", function (e) {
                e.autoStartHoldTimer = null
            }), t.signals.on("prepared", function (e) {
                var t = e.interaction,
                    n = Bo(t);
                0 < n && (t.autoStartHoldTimer = setTimeout(function () {
                    t.start(t.prepared, t.interactable, t.element)
                }, n))
            }), n.signals.on("move", function (e) {
                var t = e.interaction,
                    n = e.duplicate;
                t.pointerWasMoved && !n && clearTimeout(t.autoStartHoldTimer)
            }), t.signals.on("before-start", function (e) {
                var t = e.interaction;
                0 < Bo(t) && (t.prepared.name = null)
            })
        },
        getHoldDuration: Bo
    };
    qo.default = Ho;
    var $o = {};
    Object.defineProperty($o, "__esModule", {
        value: !0
    }), $o.install = function (e) {
        e.usePlugin(Ko.default), e.usePlugin(Jo.default), e.usePlugin(Qo.default)
    }, Object.defineProperty($o, "autoStart", {
        enumerable: !0,
        get: function () {
            return Ko.default
        }
    }), Object.defineProperty($o, "dragAxis", {
        enumerable: !0,
        get: function () {
            return Qo.default
        }
    }), Object.defineProperty($o, "hold", {
        enumerable: !0,
        get: function () {
            return Jo.default
        }
    }), $o.id = void 0;
    var Ko = Zo(_o),
        Qo = Zo(Wo),
        Jo = Zo(qo);

    function Zo(e) {
        return e && e.__esModule ? e : {
            default: e
        }
    }
    $o.id = "auto-start";
    var ei = {};
    Object.defineProperty(ei, "__esModule", {
        value: !0
    }), ei.install = si, ei.default = void 0;
    var ti, ni = (ti = de) && ti.__esModule ? ti : {
            default: ti
        },
        ri = function (e) {
            if (e && e.__esModule) return e;
            var t = oi();
            if (t && t.has(e)) return t.get(e);
            var n = {};
            if (null != e) {
                var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
                for (var o in e)
                    if (Object.prototype.hasOwnProperty.call(e, o)) {
                        var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                        i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                    }
            }
            n.default = e, t && t.set(e, n);
            return n
        }(y);

    function oi() {
        if ("function" != typeof WeakMap) return null;
        var e = new WeakMap;
        return oi = function () {
            return e
        }, e
    }

    function ii(e) {
        return /^(always|never|auto)$/.test(e) ? (this.options.preventDefault = e, this) : ri.bool(e) ? (this.options.preventDefault = e ? "always" : "never", this) : this.options.preventDefault
    }

    function ai(e) {
        var t = e.interaction,
            n = e.event;
        t.interactable && t.interactable.checkAndPreventDefault(n)
    }

    function si(r) {
        var e = r.Interactable;
        e.prototype.preventDefault = ii, e.prototype.checkAndPreventDefault = function (e) {
            return function (e, t, n) {
                var r = e.options.preventDefault;
                if ("never" !== r)
                    if ("always" !== r) {
                        if (ni.default.supportsPassive && /^touch(start|move)$/.test(n.type)) {
                            var o = (0, l.getWindow)(n.target).document,
                                i = t.getDocOptions(o);
                            if (!i || !i.events || !1 !== i.events.passive) return
                        }
                        /^(mouse|pointer|touch)*(down|start)/i.test(n.type) || ri.element(n.target) && (0, A.matchesSelector)(n.target, "input,select,textarea,[contenteditable=true],[contenteditable=true] *") || n.preventDefault()
                    } else n.preventDefault()
            }(this, r, e)
        };
        for (var t = ["down", "move", "up", "cancel"], n = 0; n < t.length; n++) {
            var o = t[n];
            r.interactions.signals.on(o, ai)
        }
        r.interactions.docEvents.push({
            type: "dragstart",
            listener: function (e) {
                for (var t = 0; t < r.interactions.list.length; t++) {
                    var n = r.interactions.list[t];
                    if (n.element && (n.element === e.target || (0, A.nodeContains)(n.element, e.target))) return void n.interactable.checkAndPreventDefault(e)
                }
            }
        })
    }
    var ui = {
        id: "core/interactablePreventDefault",
        install: si
    };
    ei.default = ui;
    var li = {};
    Object.defineProperty(li, "__esModule", {
        value: !0
    }), li.default = void 0;
    var ci, fi;
    di(k), di(Ce),
        function (e) {
            if (e && e.__esModule) return;
            var t = pi();
            if (t && t.has(e)) return t.get(e);
            var n = {};
            if (null != e) {
                var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
                for (var o in e)
                    if (Object.prototype.hasOwnProperty.call(e, o)) {
                        var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                        i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                    }
            }
            n.default = e, t && t.set(e, n)
        }(y), di(l);

    function pi() {
        if ("function" != typeof WeakMap) return null;
        var e = new WeakMap;
        return pi = function () {
            return e
        }, e
    }

    function di(e) {
        return e && e.__esModule ? e : {
            default: e
        }
    }(fi = ci = ci || {}).touchAction = "", fi.boxSizing = "", fi.noListeners = "";
    var vi = "dev-tools",
        gi = {
            id: vi,
            install: function () {}
        };
    li.default = gi;
    var hi = {};
    Object.defineProperty(hi, "__esModule", {
        value: !0
    }), hi.startAll = Oi, hi.setAll = Pi, hi.prepareStates = Ei, hi.setCoords = Si, hi.restoreCoords = ki, hi.makeModifier = Ii, hi.default = void 0;
    var yi, mi = (yi = Ce) && yi.__esModule ? yi : {
        default: yi
    };

    function bi(e, t) {
        return function (e) {
            if (Array.isArray(e)) return e
        }(e) || function (e, t) {
            if (!(Symbol.iterator in Object(e) || "[object Arguments]" === Object.prototype.toString.call(e))) return;
            var n = [],
                r = !0,
                o = !1,
                i = void 0;
            try {
                for (var a, s = e[Symbol.iterator](); !(r = (a = s.next()).done) && (n.push(a.value), !t || n.length !== t); r = !0);
            } catch (e) {
                o = !0, i = e
            } finally {
                try {
                    r || null == s.return || s.return()
                } finally {
                    if (o) throw i
                }
            }
            return n
        }(e, t) || function () {
            throw new TypeError("Invalid attempt to destructure non-iterable instance")
        }()
    }

    function wi(e, t, n) {
        var r = e.interaction,
            o = e.phase,
            i = r.interactable,
            a = r.element,
            s = Ei(Mi(r)),
            u = (0, mi.default)({}, r.rect);
        "width" in u || (u.width = u.right - u.left), "height" in u || (u.height = u.bottom - u.top);
        var l = Di(u, t);
        r.modifiers.startOffset = l, r.modifiers.startDelta = {
            x: 0,
            y: 0
        };
        var c = {
            interaction: r,
            interactable: i,
            element: a,
            pageCoords: t,
            phase: o,
            rect: u,
            startOffset: l,
            states: s,
            preEnd: !1,
            requireEndOnly: !1,
            prevCoords: n || (r.modifiers.result ? r.modifiers.result.coords : r.coords.prev.page)
        };
        return r.modifiers.states = s, r.modifiers.result = null, Oi(c), r.modifiers.result = Pi(c)
    }

    function Oi(e) {
        for (var t = e.states, n = 0; n < t.length; n++) {
            var r = t[n];
            r.methods.start && (e.state = r).methods.start(e)
        }
    }

    function Pi(e) {
        var t = e.prevCoords,
            n = e.phase,
            r = e.preEnd,
            o = e.requireEndOnly,
            i = e.rect,
            a = e.states;
        e.coords = (0, mi.default)({}, e.pageCoords), e.rect = (0, mi.default)({}, i);
        for (var s = {
                delta: {
                    x: 0,
                    y: 0
                },
                rectDelta: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                },
                coords: e.coords,
                changed: !0
            }, u = 0; u < a.length; u++) {
            var l = a[u],
                c = l.options;
            l.methods.set && Ti(c, r, o, n) && (e.state = l).methods.set(e)
        }
        s.delta.x = e.coords.x - e.pageCoords.x, s.delta.y = e.coords.y - e.pageCoords.y;
        var f = !1;
        return i && (s.rectDelta.left = e.rect.left - i.left, s.rectDelta.right = e.rect.right - i.right, s.rectDelta.top = e.rect.top - i.top, s.rectDelta.bottom = e.rect.bottom - i.bottom, f = 0 !== s.rectDelta.left || 0 !== s.rectDelta.right || 0 !== s.rectDelta.top || 0 !== s.rectDelta.bottom), s.changed = !t || t.x !== s.coords.x || t.y !== s.coords.y || f, s
    }

    function _i(e) {
        var t = e.interaction,
            n = e.phase,
            r = e.preEnd,
            o = e.skipModifiers,
            i = t.interactable,
            a = t.element,
            s = o ? t.modifiers.states.slice(o) : t.modifiers.states,
            u = e.prevCoords || (t.modifiers.result ? t.modifiers.result.coords : t.coords.prev.page),
            l = Pi({
                interaction: t,
                interactable: i,
                element: a,
                preEnd: r,
                phase: n,
                pageCoords: e.modifiedCoords || t.coords.cur.page,
                prevCoords: u,
                rect: t.rect,
                states: s,
                requireEndOnly: !1
            });
        if (!(t.modifiers.result = l).changed && t.interacting()) return !1;
        if (e.modifiedCoords) {
            var c = t.coords.cur.page,
                f = e.modifiedCoords.x - c.x,
                p = e.modifiedCoords.y - c.y;
            l.coords.x += f, l.coords.y += p, l.delta.x += f, l.delta.y += p
        }
        Si(e)
    }

    function xi(e) {
        var t = e.interaction,
            n = e.event,
            r = e.noPreEnd,
            o = t.modifiers.states;
        if (!r && o && o.length)
            for (var i = !1, a = 0; a < o.length; a++) {
                var s = o[a],
                    u = (e.state = s).options,
                    l = s.methods;
                if (!1 === (l.beforeEnd && l.beforeEnd(e))) return !(t.modifiers.endPrevented = !0);
                !i && Ti(u, !0, !0) && (t.move({
                    event: n,
                    preEnd: !0
                }), i = !0)
            }
    }

    function ji(e) {
        var t = e.interaction,
            n = t.modifiers.states;
        if (n && n.length) {
            for (var r = (0, mi.default)({
                    states: n,
                    interactable: t.interactable,
                    element: t.element,
                    rect: null
                }, e), o = 0; o < n.length; o++) {
                var i = n[o];
                (r.state = i).methods.stop && i.methods.stop(r)
            }
            e.interaction.modifiers.states = null, e.interaction.modifiers.endPrevented = !1
        }
    }

    function Mi(e) {
        var n = e.interactable.options[e.prepared.name],
            t = n.modifiers;
        return t && t.length ? t.filter(function (e) {
            return !e.options || !1 !== e.options.enabled
        }) : ["snap", "snapSize", "snapEdges", "restrict", "restrictEdges", "restrictSize"].map(function (e) {
            var t = n[e];
            return t && t.enabled && {
                options: t,
                methods: t._methods
            }
        }).filter(function (e) {
            return !!e
        })
    }

    function Ei(e) {
        for (var t = [], n = 0; n < e.length; n++) {
            var r = e[n],
                o = r.options,
                i = r.methods,
                a = r.name;
            o && !1 === o.enabled || t.push({
                options: o,
                methods: i,
                index: n,
                name: a
            })
        }
        return t
    }

    function Si(e) {
        var t = e.interaction,
            n = e.phase,
            r = t.coords.cur,
            o = t.coords.start,
            i = t.modifiers,
            a = i.result,
            s = i.startDelta,
            u = a.delta;
        "start" === n && (0, mi.default)(t.modifiers.startDelta, a.delta);
        for (var l = [
                [o, s],
                [r, u]
            ], c = 0; c < l.length; c++) {
            var f = bi(l[c], 2),
                p = f[0],
                d = f[1];
            p.page.x += d.x, p.page.y += d.y, p.client.x += d.x, p.client.y += d.y
        }
        var v = t.modifiers.result.rectDelta,
            g = e.rect || t.rect;
        g.left += v.left, g.right += v.right, g.top += v.top, g.bottom += v.bottom, g.width = g.right - g.left, g.height = g.bottom - g.top
    }

    function ki(e) {
        var t = e.interaction,
            n = t.coords,
            r = t.rect,
            o = t.modifiers;
        if (o.result) {
            for (var i = o.startDelta, a = o.result, s = a.delta, u = a.rectDelta, l = [
                    [n.start, i],
                    [n.cur, s]
                ], c = 0; c < l.length; c++) {
                var f = bi(l[c], 2),
                    p = f[0],
                    d = f[1];
                p.page.x -= d.x, p.page.y -= d.y, p.client.x -= d.x, p.client.y -= d.y
            }
            r.left -= u.left, r.right -= u.right, r.top -= u.top, r.bottom -= u.bottom
        }
    }

    function Ti(e, t, n, r) {
        return e ? !1 !== e.enabled && (t || !e.endOnly) && (!n || e.endOnly || e.alwaysOnEnd) && (e.setStart || "start" !== r) : !n
    }

    function Di(e, t) {
        return e ? {
            left: t.x - e.left,
            top: t.y - e.top,
            right: e.right - t.x,
            bottom: e.bottom - t.y
        } : {
            left: 0,
            top: 0,
            right: 0,
            bottom: 0
        }
    }

    function Ii(e, r) {
        function t(e) {
            var t = e || {};
            for (var n in t.enabled = !1 !== t.enabled, o) n in t || (t[n] = o[n]);
            return {
                options: t,
                methods: i,
                name: r
            }
        }
        var o = e.defaults,
            i = {
                start: e.start,
                set: e.set,
                beforeEnd: e.beforeEnd,
                stop: e.stop
            };
        return r && "string" == typeof r && (t._defaults = o, t._methods = i), t
    }
    var zi = {
        id: "modifiers/base",
        install: function (e) {
            var t = e.interactions;
            e.defaults.perAction.modifiers = [], t.signals.on("new", function (e) {
                e.interaction.modifiers = {
                    startOffset: {
                        left: 0,
                        right: 0,
                        top: 0,
                        bottom: 0
                    },
                    offsets: {},
                    states: null,
                    result: null,
                    endPrevented: !1,
                    startDelta: null
                }
            }), t.signals.on("before-action-start", function (e) {
                wi(e, e.interaction.coords.start.page, e.interaction.coords.prev.page)
            }), t.signals.on("action-resume", function (e) {
                ji(e), wi(e, e.interaction.coords.cur.page, e.interaction.modifiers.result.coords), _i(e)
            }), t.signals.on("after-action-move", ki), t.signals.on("before-action-move", _i), t.signals.on("before-action-start", Si), t.signals.on("after-action-start", ki), t.signals.on("before-action-end", xi), t.signals.on("stop", ji)
        },
        startAll: Oi,
        setAll: Pi,
        prepareStates: Ei,
        start: wi,
        beforeMove: _i,
        beforeEnd: xi,
        stop: ji,
        shouldDo: Ti,
        getModifierList: Mi,
        getRectOffset: Di,
        makeModifier: Ii
    };
    hi.default = zi;
    var Ai = {};
    Object.defineProperty(Ai, "__esModule", {
        value: !0
    }), Ai.default = void 0;
    var Ci, Ri = Ni(hi),
        Wi = Ni(lt),
        Xi = (Ci = tt) && Ci.__esModule ? Ci : {
            default: Ci
        };

    function Yi() {
        if ("function" != typeof WeakMap) return null;
        var e = new WeakMap;
        return Yi = function () {
            return e
        }, e
    }

    function Ni(e) {
        if (e && e.__esModule) return e;
        var t = Yi();
        if (t && t.has(e)) return t.get(e);
        var n = {};
        if (null != e) {
            var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
            for (var o in e)
                if (Object.prototype.hasOwnProperty.call(e, o)) {
                    var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                    i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                }
        }
        return n.default = e, t && t.set(e, n), n
    }

    function Fi(e) {
        var t = e.interaction,
            n = t.inertia;
        n.active && (Xi.default.cancel(n.timeout), n.active = !1, t.simulation = null)
    }

    function Li(e, t) {
        var n = Ui(e),
            r = n.resistance,
            o = -Math.log(n.endSpeed / t.v0) / r;
        t.x0 = e.prevEvent.page.x, t.y0 = e.prevEvent.page.y, t.t0 = t.startEvent.timeStamp / 1e3, t.sx = t.sy = 0, t.modifiedXe = t.xe = (t.vx0 - o) / r, t.modifiedYe = t.ye = (t.vy0 - o) / r, t.te = o, t.lambda_v0 = r / t.v0, t.one_ve_v0 = 1 - n.endSpeed / t.v0
    }

    function Vi(e) {
        Gi(e), Wi.pointer.setCoordDeltas(e.coords.delta, e.coords.prev, e.coords.cur), Wi.pointer.setCoordVelocity(e.coords.velocity, e.coords.delta);
        var t = e.inertia,
            n = Ui(e).resistance,
            r = e._now() / 1e3 - t.t0;
        if (r < t.te) {
            var o = 1 - (Math.exp(-n * r) - t.lambda_v0) / t.one_ve_v0;
            if (t.modifiedXe === t.xe && t.modifiedYe === t.ye) t.sx = t.xe * o, t.sy = t.ye * o;
            else {
                var i = Wi.getQuadraticCurvePoint(0, 0, t.xe, t.ye, t.modifiedXe, t.modifiedYe, o);
                t.sx = i.x, t.sy = i.y
            }
            e.move(), t.timeout = Xi.default.request(function () {
                return Vi(e)
            })
        } else t.sx = t.modifiedXe, t.sy = t.modifiedYe, e.move(), e.end(t.startEvent), t.active = !1, e.simulation = null;
        Wi.pointer.copyCoords(e.coords.prev, e.coords.cur)
    }

    function qi(e) {
        Gi(e);
        var t = e.inertia,
            n = e._now() - t.t0,
            r = Ui(e).smoothEndDuration;
        n < r ? (t.sx = Wi.easeOutQuad(n, 0, t.xe, r), t.sy = Wi.easeOutQuad(n, 0, t.ye, r), e.move(), t.timeout = Xi.default.request(function () {
            return qi(e)
        })) : (t.sx = t.xe, t.sy = t.ye, e.move(), e.end(t.startEvent), t.smoothEnd = t.active = !1, e.simulation = null)
    }

    function Gi(e) {
        var t = e.inertia;
        if (t.active) {
            var n = t.upCoords.page,
                r = t.upCoords.client;
            Wi.pointer.setCoords(e.coords.cur, [{
                pageX: n.x + t.sx,
                pageY: n.y + t.sy,
                clientX: r.x + t.sx,
                clientY: r.y + t.sy
            }], e._now())
        }
    }

    function Ui(e) {
        var t = e.interactable,
            n = e.prepared;
        return t && t.options && n.name && t.options[n.name].inertia
    }
    wn.EventPhase.Resume = "resume", wn.EventPhase.InertiaStart = "inertiastart";
    var Bi = {
        id: "inertia",
        install: function (t) {
            var e = t.interactions,
                n = t.defaults;
            e.signals.on("new", function (e) {
                e.interaction.inertia = {
                    active: !1,
                    smoothEnd: !1,
                    allowResume: !1,
                    upCoords: {},
                    timeout: null
                }
            }), e.signals.on("before-action-end", function (e) {
                return function (e, t) {
                    var n = e.interaction,
                        r = e.event,
                        o = e.noPreEnd,
                        i = n.inertia;
                    if (!n.interacting() || n.simulation && n.simulation.active || o) return null;
                    var a, s = Ui(n),
                        u = n._now(),
                        l = n.coords.velocity.client,
                        c = Wi.hypot(l.x, l.y),
                        f = !1,
                        p = s && s.enabled && "gesture" !== n.prepared.name && r !== i.startEvent,
                        d = p && u - n.coords.cur.timeStamp < 50 && c > s.minSpeed && c > s.endSpeed,
                        v = {
                            interaction: n,
                            pageCoords: n.coords.cur.page,
                            states: p && n.modifiers.states.map(function (e) {
                                return Wi.extend({}, e)
                            }),
                            preEnd: !0,
                            prevCoords: null,
                            requireEndOnly: null,
                            phase: wn.EventPhase.InertiaStart
                        };
                    p && !d && (v.prevCoords = n.modifiers.result ? n.modifiers.result.coords : n.prevEvent.page, v.requireEndOnly = !1, (a = Ri.default.setAll(v)).changed && (f = !0));
                    if (!d && !f) return null;
                    Wi.pointer.copyCoords(i.upCoords, n.coords.cur), (0, Ri.setCoords)(v), n.pointers[0].pointer = i.startEvent = new t.InteractEvent(n, r, n.prepared.name, wn.EventPhase.InertiaStart, n.element), (0, Ri.restoreCoords)(v), i.t0 = u, i.active = !0, i.allowResume = s.allowResume, n.simulation = i, n.interactable.fire(i.startEvent), d ? (i.vx0 = n.coords.velocity.client.x, i.vy0 = n.coords.velocity.client.y, i.v0 = c, Li(n, i), Wi.extend(v.pageCoords, n.coords.cur.page), v.pageCoords.x += i.xe, v.pageCoords.y += i.ye, v.prevCoords = null, v.requireEndOnly = !0, a = Ri.default.setAll(v), i.modifiedXe += a.delta.x, i.modifiedYe += a.delta.y, i.timeout = Xi.default.request(function () {
                        return Vi(n)
                    })) : (i.smoothEnd = !0, i.xe = a.delta.x, i.ye = a.delta.y, i.sx = i.sy = 0, i.timeout = Xi.default.request(function () {
                        return qi(n)
                    }));
                    return !1
                }(e, t)
            }), e.signals.on("down", function (e) {
                return function (e, t) {
                    var n = e.interaction,
                        r = e.event,
                        o = e.pointer,
                        i = e.eventTarget,
                        a = n.inertia;
                    if (a.active)
                        for (var s = i; Wi.is.element(s);) {
                            if (s === n.element) {
                                Xi.default.cancel(a.timeout), a.active = !1, n.simulation = null, n.updatePointer(o, r, i, !0), Wi.pointer.setCoords(n.coords.cur, n.pointers.map(function (e) {
                                    return e.pointer
                                }), n._now());
                                var u = {
                                    interaction: n,
                                    phase: wn.EventPhase.Resume
                                };
                                t.interactions.signals.fire("action-resume", u);
                                var l = new t.InteractEvent(n, r, n.prepared.name, wn.EventPhase.Resume, n.element);
                                n._fireEvent(l), Wi.pointer.copyCoords(n.coords.prev, n.coords.cur);
                                break
                            }
                            s = Wi.dom.parentNode(s)
                        }
                }(e, t)
            }), e.signals.on("stop", Fi), n.perAction.inertia = {
                enabled: !1,
                resistance: 10,
                minSpeed: 100,
                endSpeed: 10,
                allowResume: !0,
                smoothEndDuration: 300
            }, t.usePlugin(Ri.default)
        },
        calcInertia: Li,
        inertiaTick: Vi,
        smothEndTick: qi,
        updateInertiaCoords: Gi
    };
    Ai.default = Bi;
    var Hi = {};
    Object.defineProperty(Hi, "__esModule", {
        value: !0
    }), Hi.default = void 0;
    var $i = Zi(Ce),
        Ki = function (e) {
            if (e && e.__esModule) return e;
            var t = Ji();
            if (t && t.has(e)) return t.get(e);
            var n = {};
            if (null != e) {
                var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
                for (var o in e)
                    if (Object.prototype.hasOwnProperty.call(e, o)) {
                        var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                        i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                    }
            }
            n.default = e, t && t.set(e, n);
            return n
        }(y),
        Qi = Zi(Re);

    function Ji() {
        if ("function" != typeof WeakMap) return null;
        var e = new WeakMap;
        return Ji = function () {
            return e
        }, e
    }

    function Zi(e) {
        return e && e.__esModule ? e : {
            default: e
        }
    }

    function ea(e, t, n) {
        return Ki.func(e) ? Qi.default.resolveRectLike(e, t.interactable, t.element, [n.x, n.y, t]) : Qi.default.resolveRectLike(e, t.interactable, t.element)
    }
    var ta = {
        start: function (e) {
            var t = e.rect,
                n = e.startOffset,
                r = e.state,
                o = e.interaction,
                i = e.pageCoords,
                a = r.options,
                s = a.elementRect,
                u = (0, $i.default)({
                    left: 0,
                    top: 0,
                    right: 0,
                    bottom: 0
                }, a.offset || {});
            if (t && s) {
                var l = ea(a.restriction, o, i);
                if (l) {
                    var c = l.right - l.left - t.width,
                        f = l.bottom - l.top - t.height;
                    c < 0 && (u.left += c, u.right += c), f < 0 && (u.top += f, u.bottom += f)
                }
                u.left += n.left - t.width * s.left, u.top += n.top - t.height * s.top, u.right += n.right - t.width * (1 - s.right), u.bottom += n.bottom - t.height * (1 - s.bottom)
            }
            r.offset = u
        },
        set: function (e) {
            var t = e.coords,
                n = e.interaction,
                r = e.state,
                o = r.options,
                i = r.offset,
                a = ea(o.restriction, n, t);
            if (a) {
                var s = Qi.default.xywhToTlbr(a);
                t.x = Math.max(Math.min(s.right - i.right, t.x), s.left + i.left), t.y = Math.max(Math.min(s.bottom - i.bottom, t.y), s.top + i.top)
            }
        },
        getRestrictionRect: ea,
        defaults: {
            restriction: null,
            elementRect: null,
            offset: null,
            endOnly: !1,
            enabled: !1
        }
    };
    Hi.default = ta;
    var na = {};
    Object.defineProperty(na, "__esModule", {
        value: !0
    }), na.default = void 0;
    var ra = ia(Ce),
        oa = ia(Re);

    function ia(e) {
        return e && e.__esModule ? e : {
            default: e
        }
    }
    var aa = ia(Hi).default.getRestrictionRect,
        sa = {
            top: 1 / 0,
            left: 1 / 0,
            bottom: -1 / 0,
            right: -1 / 0
        },
        ua = {
            top: -1 / 0,
            left: -1 / 0,
            bottom: 1 / 0,
            right: 1 / 0
        };

    function la(e, t) {
        for (var n = ["top", "left", "bottom", "right"], r = 0; r < n.length; r++) {
            var o = n[r];
            o in e || (e[o] = t[o])
        }
        return e
    }
    var ca = {
        noInner: sa,
        noOuter: ua,
        getRestrictionRect: aa,
        start: function (e) {
            var t, n = e.interaction,
                r = e.state,
                o = r.options,
                i = n.modifiers.startOffset;
            if (o) {
                var a = aa(o.offset, n, n.coords.start.page);
                t = oa.default.rectToXY(a)
            }
            t = t || {
                x: 0,
                y: 0
            }, r.offset = {
                top: t.y + i.top,
                left: t.x + i.left,
                bottom: t.y - i.bottom,
                right: t.x - i.right
            }
        },
        set: function (e) {
            var t = e.coords,
                n = e.interaction,
                r = e.state,
                o = r.offset,
                i = r.options,
                a = n.prepared._linkedEdges || n.prepared.edges;
            if (a) {
                var s = (0, ra.default)({}, t),
                    u = aa(i.inner, n, s) || {},
                    l = aa(i.outer, n, s) || {};
                la(u, sa), la(l, ua), a.top ? t.y = Math.min(Math.max(l.top + o.top, s.y), u.top + o.top) : a.bottom && (t.y = Math.max(Math.min(l.bottom + o.bottom, s.y), u.bottom + o.bottom)), a.left ? t.x = Math.min(Math.max(l.left + o.left, s.x), u.left + o.left) : a.right && (t.x = Math.max(Math.min(l.right + o.right, s.x), u.right + o.right))
            }
        },
        defaults: {
            inner: null,
            outer: null,
            offset: null,
            endOnly: !1,
            enabled: !1
        }
    };
    na.default = ca;
    var fa = {};
    Object.defineProperty(fa, "__esModule", {
        value: !0
    }), fa.default = void 0;
    var pa = va(Ce),
        da = va(Hi);

    function va(e) {
        return e && e.__esModule ? e : {
            default: e
        }
    }
    var ga = (0, pa.default)({
            get elementRect() {
                return {
                    top: 0,
                    left: 0,
                    bottom: 1,
                    right: 1
                }
            },
            set elementRect(e) {}
        }, da.default.defaults),
        ha = {
            start: da.default.start,
            set: da.default.set,
            defaults: ga
        };
    fa.default = ha;
    var ya = {};
    Object.defineProperty(ya, "__esModule", {
        value: !0
    }), ya.default = void 0;
    var ma = Oa(Ce),
        ba = Oa(Re),
        wa = Oa(na);

    function Oa(e) {
        return e && e.__esModule ? e : {
            default: e
        }
    }
    var Pa = {
            width: -1 / 0,
            height: -1 / 0
        },
        _a = {
            width: 1 / 0,
            height: 1 / 0
        };
    var xa = {
        start: function (e) {
            return wa.default.start(e)
        },
        set: function (e) {
            var t = e.interaction,
                n = e.state,
                r = n.options,
                o = t.prepared._linkedEdges || t.prepared.edges;
            if (o) {
                var i = ba.default.xywhToTlbr(t.resizeRects.inverted),
                    a = ba.default.tlbrToXywh(wa.default.getRestrictionRect(r.min, t, e.coords)) || Pa,
                    s = ba.default.tlbrToXywh(wa.default.getRestrictionRect(r.max, t, e.coords)) || _a;
                n.options = {
                    endOnly: r.endOnly,
                    inner: (0, ma.default)({}, wa.default.noInner),
                    outer: (0, ma.default)({}, wa.default.noOuter)
                }, o.top ? (n.options.inner.top = i.bottom - a.height, n.options.outer.top = i.bottom - s.height) : o.bottom && (n.options.inner.bottom = i.top + a.height, n.options.outer.bottom = i.top + s.height), o.left ? (n.options.inner.left = i.right - a.width, n.options.outer.left = i.right - s.width) : o.right && (n.options.inner.right = i.left + a.width, n.options.outer.right = i.left + s.width), wa.default.set(e), n.options = r
            }
        },
        defaults: {
            min: null,
            max: null,
            endOnly: !1,
            enabled: !1
        }
    };
    ya.default = xa;
    var ja = {};
    Object.defineProperty(ja, "__esModule", {
        value: !0
    }), ja.default = void 0;
    var Ma = function (e) {
        if (e && e.__esModule) return e;
        var t = Ea();
        if (t && t.has(e)) return t.get(e);
        var n = {};
        if (null != e) {
            var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
            for (var o in e)
                if (Object.prototype.hasOwnProperty.call(e, o)) {
                    var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                    i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                }
        }
        n.default = e, t && t.set(e, n);
        return n
    }(lt);

    function Ea() {
        if ("function" != typeof WeakMap) return null;
        var e = new WeakMap;
        return Ea = function () {
            return e
        }, e
    }
    var Sa = {
        start: function (e) {
            var t, n = e.interaction,
                r = e.interactable,
                o = e.element,
                i = e.rect,
                a = e.state,
                s = e.startOffset,
                u = a.options,
                l = [],
                c = u.offsetWithOrigin ? function (e) {
                    var t = e.interaction.element;
                    return Ma.rect.rectToXY(Ma.rect.resolveRectLike(e.state.options.origin, null, null, [t])) || Ma.getOriginXY(e.interactable, t, e.interaction.prepared.name)
                }(e) : {
                    x: 0,
                    y: 0
                };
            if ("startCoords" === u.offset) t = {
                x: n.coords.start.page.x,
                y: n.coords.start.page.y
            };
            else {
                var f = Ma.rect.resolveRectLike(u.offset, r, o, [n]);
                (t = Ma.rect.rectToXY(f) || {
                    x: 0,
                    y: 0
                }).x += c.x, t.y += c.y
            }
            var p = u.relativePoints || [];
            if (i && u.relativePoints && u.relativePoints.length)
                for (var d = 0; d < p.length; d++) {
                    var v = p[d];
                    l.push({
                        index: d,
                        relativePoint: v,
                        x: s.left - i.width * v.x + t.x,
                        y: s.top - i.height * v.y + t.y
                    })
                } else l.push(Ma.extend({
                    index: 0,
                    relativePoint: null
                }, t));
            a.offsets = l
        },
        set: function (e) {
            var t, n = e.interaction,
                r = e.coords,
                o = e.state,
                i = o.options,
                a = o.offsets,
                s = Ma.getOriginXY(n.interactable, n.element, n.prepared.name),
                u = Ma.extend({}, r),
                l = [];
            i.offsetWithOrigin || (u.x -= s.x, u.y -= s.y), o.realX = u.x, o.realY = u.y;
            for (var c = 0; c < a.length; c++)
                for (var f = a[c], p = u.x - f.x, d = u.y - f.y, v = 0, g = i.targets.length; v < g; v++) {
                    var h = i.targets[v];
                    (t = Ma.is.func(h) ? h(p, d, n, f, v) : h) && l.push({
                        x: (Ma.is.number(t.x) ? t.x : p) + f.x,
                        y: (Ma.is.number(t.y) ? t.y : d) + f.y,
                        range: Ma.is.number(t.range) ? t.range : i.range
                    })
                }
            for (var y = {
                    target: null,
                    inRange: !1,
                    distance: 0,
                    range: 0,
                    dx: 0,
                    dy: 0
                }, m = 0, b = l.length; m < b; m++) {
                var w = (t = l[m]).range,
                    O = t.x - u.x,
                    P = t.y - u.y,
                    _ = Ma.hypot(O, P),
                    x = _ <= w;
                w === 1 / 0 && y.inRange && y.range !== 1 / 0 && (x = !1), y.target && !(x ? y.inRange && w !== 1 / 0 ? _ / w < y.distance / y.range : w === 1 / 0 && y.range !== 1 / 0 || _ < y.distance : !y.inRange && _ < y.distance) || (y.target = t, y.distance = _, y.range = w, y.inRange = x, y.dx = O, y.dy = P, o.range = w)
            }
            y.inRange && (r.x = y.target.x, r.y = y.target.y), o.closest = y
        },
        defaults: {
            range: 1 / 0,
            targets: null,
            offset: null,
            offsetWithOrigin: !0,
            origin: null,
            relativePoints: null,
            endOnly: !1,
            enabled: !1
        }
    };
    ja.default = Sa;
    var ka = {};
    Object.defineProperty(ka, "__esModule", {
        value: !0
    }), ka.default = void 0;
    var Ta = Aa(Ce),
        Da = function (e) {
            if (e && e.__esModule) return e;
            var t = za();
            if (t && t.has(e)) return t.get(e);
            var n = {};
            if (null != e) {
                var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
                for (var o in e)
                    if (Object.prototype.hasOwnProperty.call(e, o)) {
                        var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                        i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                    }
            }
            n.default = e, t && t.set(e, n);
            return n
        }(y),
        Ia = Aa(ja);

    function za() {
        if ("function" != typeof WeakMap) return null;
        var e = new WeakMap;
        return za = function () {
            return e
        }, e
    }

    function Aa(e) {
        return e && e.__esModule ? e : {
            default: e
        }
    }

    function Ca(e, t) {
        return function (e) {
            if (Array.isArray(e)) return e
        }(e) || function (e, t) {
            if (!(Symbol.iterator in Object(e) || "[object Arguments]" === Object.prototype.toString.call(e))) return;
            var n = [],
                r = !0,
                o = !1,
                i = void 0;
            try {
                for (var a, s = e[Symbol.iterator](); !(r = (a = s.next()).done) && (n.push(a.value), !t || n.length !== t); r = !0);
            } catch (e) {
                o = !0, i = e
            } finally {
                try {
                    r || null == s.return || s.return()
                } finally {
                    if (o) throw i
                }
            }
            return n
        }(e, t) || function () {
            throw new TypeError("Invalid attempt to destructure non-iterable instance")
        }()
    }
    var Ra = {
        start: function (e) {
            var t = e.interaction,
                n = e.state,
                r = n.options,
                o = t.prepared.edges;
            if (!o) return null;
            e.state = {
                options: {
                    targets: null,
                    relativePoints: [{
                        x: o.left ? 0 : 1,
                        y: o.top ? 0 : 1
                    }],
                    offset: r.offset || "self",
                    origin: {
                        x: 0,
                        y: 0
                    },
                    range: r.range
                }
            }, n.targetFields = n.targetFields || [
                ["width", "height"],
                ["x", "y"]
            ], Ia.default.start(e), n.offsets = e.state.offsets, e.state = n
        },
        set: function (e) {
            var t = e.interaction,
                n = e.state,
                r = e.coords,
                o = n.options,
                i = n.offsets,
                a = {
                    x: r.x - i[0].x,
                    y: r.y - i[0].y
                };
            n.options = (0, Ta.default)({}, o), n.options.targets = [];
            for (var s = 0; s < (o.targets || []).length; s++) {
                var u = (o.targets || [])[s],
                    l = void 0;
                if (l = Da.func(u) ? u(a.x, a.y, t) : u) {
                    for (var c = 0; c < n.targetFields.length; c++) {
                        var f = Ca(n.targetFields[c], 2),
                            p = f[0],
                            d = f[1];
                        if (p in l || d in l) {
                            l.x = l[p], l.y = l[d];
                            break
                        }
                    }
                    n.options.targets.push(l)
                }
            }
            Ia.default.set(e), n.options = o
        },
        defaults: {
            range: 1 / 0,
            targets: null,
            offset: null,
            endOnly: !1,
            enabled: !1
        }
    };
    ka.default = Ra;
    var Wa = {};
    Object.defineProperty(Wa, "__esModule", {
        value: !0
    }), Wa.default = void 0;
    var Xa = Fa(B),
        Ya = Fa(Ce),
        Na = Fa(ka);

    function Fa(e) {
        return e && e.__esModule ? e : {
            default: e
        }
    }
    var La = {
        start: function (e) {
            var t = e.interaction.prepared.edges;
            return t ? (e.state.targetFields = e.state.targetFields || [
                [t.left ? "left" : "right", t.top ? "top" : "bottom"]
            ], Na.default.start(e)) : null
        },
        set: function (e) {
            return Na.default.set(e)
        },
        defaults: (0, Ya.default)((0, Xa.default)(Na.default.defaults), {
            offset: {
                x: 0,
                y: 0
            }
        })
    };
    Wa.default = La;
    var Va = {};
    Object.defineProperty(Va, "__esModule", {
        value: !0
    }), Va.restrictSize = Va.restrictEdges = Va.restrictRect = Va.restrict = Va.snapEdges = Va.snapSize = Va.snap = void 0;
    var qa = Ja(hi),
        Ga = Ja(na),
        Ua = Ja(Hi),
        Ba = Ja(fa),
        Ha = Ja(ya),
        $a = Ja(Wa),
        Ka = Ja(ja),
        Qa = Ja(ka);

    function Ja(e) {
        return e && e.__esModule ? e : {
            default: e
        }
    }
    var Za = qa.default.makeModifier,
        es = Za(Ka.default, "snap");
    Va.snap = es;
    var ts = Za(Qa.default, "snapSize");
    Va.snapSize = ts;
    var ns = Za($a.default, "snapEdges");
    Va.snapEdges = ns;
    var rs = Za(Ua.default, "restrict");
    Va.restrict = rs;
    var os = Za(Ba.default, "restrictRect");
    Va.restrictRect = os;
    var is = Za(Ga.default, "restrictEdges");
    Va.restrictEdges = is;
    var as = Za(Ha.default, "restrictSize");
    Va.restrictSize = as;
    var ss = {};
    Object.defineProperty(ss, "__esModule", {
        value: !0
    }), ss.default = void 0;
    var us = cs(hn),
        ls = cs(ne);

    function cs(e) {
        return e && e.__esModule ? e : {
            default: e
        }
    }

    function fs(e) {
        return (fs = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
            return typeof e
        } : function (e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
        })(e)
    }

    function ps(e, t) {
        for (var n = 0; n < t.length; n++) {
            var r = t[n];
            r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
        }
    }

    function ds(e) {
        return (ds = Object.setPrototypeOf ? Object.getPrototypeOf : function (e) {
            return e.__proto__ || Object.getPrototypeOf(e)
        })(e)
    }

    function vs(e) {
        if (void 0 === e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
        return e
    }

    function gs(e, t) {
        return (gs = Object.setPrototypeOf || function (e, t) {
            return e.__proto__ = t, e
        })(e, t)
    }
    var hs = function () {
        function l(e, t, n, r, o, i) {
            var a;
            if (! function (e, t) {
                    if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
                }(this, l), a = function (e, t) {
                    return !t || "object" !== fs(t) && "function" != typeof t ? vs(e) : t
                }(this, ds(l).call(this, o)), ls.default.pointerExtend(vs(a), n), n !== t && ls.default.pointerExtend(vs(a), t), a.timeStamp = i, a.originalEvent = n, a.type = e, a.pointerId = ls.default.getPointerId(t), a.pointerType = ls.default.getPointerType(t), a.target = r, a.currentTarget = null, "tap" === e) {
                var s = o.getPointerIndex(t);
                a.dt = a.timeStamp - o.pointers[s].downTime;
                var u = a.timeStamp - o.tapTime;
                a.double = !!(o.prevTap && "doubletap" !== o.prevTap.type && o.prevTap.target === a.target && u < 500)
            } else "doubletap" === e && (a.dt = t.timeStamp - o.tapTime);
            return a
        }
        return function (e, t) {
                if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function");
                e.prototype = Object.create(t && t.prototype, {
                    constructor: {
                        value: e,
                        writable: !0,
                        configurable: !0
                    }
                }), t && gs(e, t)
            }(l, us["default"]),
            function (e, t, n) {
                t && ps(e.prototype, t), n && ps(e, n)
            }(l, [{
                key: "_subtractOrigin",
                value: function (e) {
                    var t = e.x,
                        n = e.y;
                    return this.pageX -= t, this.pageY -= n, this.clientX -= t, this.clientY -= n, this
                }
            }, {
                key: "_addOrigin",
                value: function (e) {
                    var t = e.x,
                        n = e.y;
                    return this.pageX += t, this.pageY += n, this.clientX += t, this.clientY += n, this
                }
            }, {
                key: "preventDefault",
                value: function () {
                    this.originalEvent.preventDefault()
                }
            }]), l
    }();
    ss.default = hs;
    var ys = {};
    Object.defineProperty(ys, "__esModule", {
        value: !0
    }), ys.default = void 0;
    var ms, bs = function (e) {
            if (e && e.__esModule) return e;
            var t = Os();
            if (t && t.has(e)) return t.get(e);
            var n = {};
            if (null != e) {
                var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
                for (var o in e)
                    if (Object.prototype.hasOwnProperty.call(e, o)) {
                        var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                        i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                    }
            }
            n.default = e, t && t.set(e, n);
            return n
        }(lt),
        ws = (ms = ss) && ms.__esModule ? ms : {
            default: ms
        };

    function Os() {
        if ("function" != typeof WeakMap) return null;
        var e = new WeakMap;
        return Os = function () {
            return e
        }, e
    }
    var Ps = new bs.Signals,
        _s = ["down", "up", "cancel"],
        xs = ["down", "up", "cancel"],
        js = {
            id: "pointer-events/base",
            install: function (v) {
                var e = v.interactions;
                v.pointerEvents = js, v.defaults.actions.pointerEvents = js.defaults, e.signals.on("new", function (e) {
                    var t = e.interaction;
                    t.prevTap = null, t.tapTime = 0
                }), e.signals.on("update-pointer", function (e) {
                    var t = e.down,
                        n = e.pointerInfo;
                    !t && n.hold || (n.hold = {
                        duration: 1 / 0,
                        timeout: null
                    })
                }), e.signals.on("move", function (e) {
                    var t = e.interaction,
                        n = e.pointer,
                        r = e.event,
                        o = e.eventTarget,
                        i = e.duplicateMove,
                        a = t.getPointerIndex(n);
                    i || t.pointerIsDown && !t.pointerWasMoved || (t.pointerIsDown && clearTimeout(t.pointers[a].hold.timeout), Ms({
                        interaction: t,
                        pointer: n,
                        event: r,
                        eventTarget: o,
                        type: "move"
                    }, v))
                }), e.signals.on("down", function (e) {
                    for (var t = e.interaction, n = e.pointer, r = e.event, o = e.eventTarget, i = e.pointerIndex, a = t.pointers[i].hold, s = bs.dom.getPath(o), u = {
                            interaction: t,
                            pointer: n,
                            event: r,
                            eventTarget: o,
                            type: "hold",
                            targets: [],
                            path: s,
                            node: null
                        }, l = 0; l < s.length; l++) {
                        var c = s[l];
                        u.node = c, Ps.fire("collect-targets", u)
                    }
                    if (u.targets.length) {
                        for (var f = 1 / 0, p = 0; p < u.targets.length; p++) {
                            var d = u.targets[p].eventable.options.holdDuration;
                            d < f && (f = d)
                        }
                        a.duration = f, a.timeout = setTimeout(function () {
                            Ms({
                                interaction: t,
                                eventTarget: o,
                                pointer: n,
                                event: r,
                                type: "hold"
                            }, v)
                        }, f)
                    }
                });
                for (var t = ["up", "cancel"], n = 0; n < t.length; n++) {
                    var r = t[n];
                    e.signals.on(r, function (e) {
                        var t = e.interaction,
                            n = e.pointerIndex;
                        t.pointers[n].hold && clearTimeout(t.pointers[n].hold.timeout)
                    })
                }
                for (var o = 0; o < _s.length; o++) e.signals.on(_s[o], Ss(xs[o], v));
                e.signals.on("up", function (e) {
                    var t = e.interaction,
                        n = e.pointer,
                        r = e.event,
                        o = e.eventTarget;
                    t.pointerWasMoved || Ms({
                        interaction: t,
                        eventTarget: o,
                        pointer: n,
                        event: r,
                        type: "tap"
                    }, v)
                })
            },
            signals: Ps,
            PointerEvent: ws.default,
            fire: Ms,
            collectEventTargets: Es,
            createSignalListener: Ss,
            defaults: {
                holdDuration: 600,
                ignoreFrom: null,
                allowFrom: null,
                origin: {
                    x: 0,
                    y: 0
                }
            },
            types: ["down", "move", "up", "cancel", "tap", "doubletap", "hold"]
        };

    function Ms(e, t) {
        for (var n = e.interaction, r = e.pointer, o = e.event, i = e.eventTarget, a = e.type, s = void 0 === a ? e.pointerEvent.type : a, u = e.targets, l = void 0 === u ? Es(e) : u, c = e.pointerEvent, f = void 0 === c ? new ws.default(s, r, o, i, n, t.now()) : c, p = {
                interaction: n,
                pointer: r,
                event: o,
                eventTarget: i,
                targets: l,
                type: s,
                pointerEvent: f
            }, d = 0; d < l.length; d++) {
            var v = l[d];
            for (var g in v.props || {}) f[g] = v.props[g];
            var h = bs.getOriginXY(v.eventable, v.node);
            if (f._subtractOrigin(h), f.eventable = v.eventable, f.currentTarget = v.node, v.eventable.fire(f), f._addOrigin(h), f.immediatePropagationStopped || f.propagationStopped && d + 1 < l.length && l[d + 1].node !== f.currentTarget) break
        }
        if (Ps.fire("fired", p), "tap" === s) {
            var y = f.double ? Ms({
                interaction: n,
                pointer: r,
                event: o,
                eventTarget: i,
                type: "doubletap"
            }, t) : f;
            n.prevTap = y, n.tapTime = y.timeStamp
        }
        return f
    }

    function Es(e) {
        var t = e.interaction,
            n = e.pointer,
            r = e.event,
            o = e.eventTarget,
            i = e.type,
            a = t.getPointerIndex(n),
            s = t.pointers[a];
        if ("tap" === i && (t.pointerWasMoved || !s || s.downTarget !== o)) return [];
        for (var u = bs.dom.getPath(o), l = {
                interaction: t,
                pointer: n,
                event: r,
                eventTarget: o,
                type: i,
                path: u,
                targets: [],
                node: null
            }, c = 0; c < u.length; c++) {
            var f = u[c];
            l.node = f, Ps.fire("collect-targets", l)
        }
        return "hold" === i && (l.targets = l.targets.filter(function (e) {
            return e.eventable.options.holdDuration === t.pointers[a].hold.duration
        })), l.targets
    }

    function Ss(o, i) {
        return function (e) {
            var t = e.interaction,
                n = e.pointer,
                r = e.event;
            Ms({
                interaction: t,
                eventTarget: e.eventTarget,
                pointer: n,
                event: r,
                type: o
            }, i)
        }
    }
    var ks = js;
    ys.default = ks;
    var Ts = {};
    Object.defineProperty(Ts, "__esModule", {
        value: !0
    }), Ts.default = void 0;
    var Ds, Is = (Ds = ys) && Ds.__esModule ? Ds : {
        default: Ds
    };

    function zs(e) {
        var t = e.pointerEvent;
        "hold" === t.type && (t.count = (t.count || 0) + 1)
    }

    function As(e) {
        var t = e.interaction;
        t.holdIntervalHandle && (clearInterval(t.holdIntervalHandle), t.holdIntervalHandle = null)
    }
    var Cs = {
        id: "pointer-events/holdRepeat",
        install: function (t) {
            var e = t.pointerEvents,
                n = t.interactions;
            t.usePlugin(Is.default), e.signals.on("new", zs), e.signals.on("fired", function (e) {
                return function (e, t) {
                    var n = e.interaction,
                        r = e.pointerEvent,
                        o = e.eventTarget,
                        i = e.targets;
                    if ("hold" !== r.type || !i.length) return;
                    var a = i[0].eventable.options.holdRepeatInterval;
                    if (a <= 0) return;
                    n.holdIntervalHandle = setTimeout(function () {
                        t.pointerEvents.fire({
                            interaction: n,
                            eventTarget: o,
                            type: "hold",
                            pointer: r,
                            event: r
                        }, t)
                    }, a)
                }(e, t)
            });
            for (var r = ["move", "up", "cancel", "endall"], o = 0; o < r.length; o++) {
                var i = r[o];
                n.signals.on(i, As)
            }
            e.defaults.holdRepeatInterval = 0, e.types.push("holdrepeat")
        }
    };
    Ts.default = Cs;
    var Rs = {};
    Object.defineProperty(Rs, "__esModule", {
        value: !0
    }), Rs.default = void 0;
    var Ws, Xs = (Ws = Ce) && Ws.__esModule ? Ws : {
        default: Ws
    };

    function Ys(e) {
        return (0, Xs.default)(this.events.options, e), this
    }
    var Ns = {
        id: "pointer-events/interactableTargets",
        install: function (t) {
            var r = t.pointerEvents,
                e = t.actions,
                n = t.Interactable,
                o = t.interactables;
            r.signals.on("collect-targets", function (e) {
                var r = e.targets,
                    o = e.node,
                    i = e.type,
                    a = e.eventTarget;
                t.interactables.forEachMatch(o, function (e) {
                    var t = e.events,
                        n = t.options;
                    t.types[i] && t.types[i].length && e.testIgnoreAllow(n, o, a) && r.push({
                        node: o,
                        eventable: t,
                        props: {
                            interactable: e
                        }
                    })
                })
            }), o.signals.on("new", function (e) {
                var t = e.interactable;
                t.events.getRect = function (e) {
                    return t.getRect(e)
                }
            }), o.signals.on("set", function (e) {
                var t = e.interactable,
                    n = e.options;
                (0, Xs.default)(t.events.options, r.defaults), (0, Xs.default)(t.events.options, n.pointerEvents || {})
            }), (0, s.merge)(e.eventTypes, r.types), n.prototype.pointerEvents = Ys;
            var i = n.prototype._backCompatOption;
            n.prototype._backCompatOption = function (e, t) {
                var n = i.call(this, e, t);
                return n === this && (this.events.options[e] = t), n
            }
        }
    };
    Rs.default = Ns;
    var Fs = {};
    Object.defineProperty(Fs, "__esModule", {
        value: !0
    }), Fs.install = function (e) {
        e.usePlugin(Ls.default), e.usePlugin(Vs.default), e.usePlugin(qs.default)
    }, Object.defineProperty(Fs, "pointerEvents", {
        enumerable: !0,
        get: function () {
            return Ls.default
        }
    }), Object.defineProperty(Fs, "holdRepeat", {
        enumerable: !0,
        get: function () {
            return Vs.default
        }
    }), Object.defineProperty(Fs, "interactableTargets", {
        enumerable: !0,
        get: function () {
            return qs.default
        }
    }), Fs.id = void 0;
    var Ls = Gs(ys),
        Vs = Gs(Ts),
        qs = Gs(Rs);

    function Gs(e) {
        return e && e.__esModule ? e : {
            default: e
        }
    }
    Fs.id = "pointer-events";
    var Us = {};

    function Bs(n) {
        for (var e = n.actions, t = n.interactions, r = n.Interactable, o = 0; o < e.names.length; o++) {
            var i = e.names[o];
            e.eventTypes.push("".concat(i, "reflow"))
        }
        t.signals.on("stop", function (e) {
            var t = e.interaction;
            t.pointerType === wn.EventPhase.Reflow && (t._reflowResolve && t._reflowResolve(), lt.arr.remove(n.interactions.list, t))
        }), r.prototype.reflow = function (e) {
            return function (s, u, l) {
                function e() {
                    var t = c[d],
                        e = s.getRect(t);
                    if (!e) return "break";
                    var n = lt.arr.find(l.interactions.list, function (e) {
                            return e.interacting() && e.interactable === s && e.element === t && e.prepared.name === u.name
                        }),
                        r = void 0;
                    if (n) n.move(), p && (r = n._reflowPromise || new f(function (e) {
                        n._reflowResolve = e
                    }));
                    else {
                        var o = lt.rect.tlbrToXywh(e),
                            i = {
                                page: {
                                    x: o.x,
                                    y: o.y
                                },
                                client: {
                                    x: o.x,
                                    y: o.y
                                },
                                timeStamp: l.now()
                            },
                            a = lt.pointer.coordsToEvent(i);
                        r = function (e, t, n, r, o) {
                            var i = e.interactions.new({
                                    pointerType: "reflow"
                                }),
                                a = {
                                    interaction: i,
                                    event: o,
                                    pointer: o,
                                    eventTarget: n,
                                    phase: wn.EventPhase.Reflow
                                };
                            i.interactable = t, i.element = n, i.prepared = (0, lt.extend)({}, r), i.prevEvent = o, i.updatePointer(o, o, n, !0), i._doPhase(a);
                            var s = lt.win.window.Promise ? new lt.win.window.Promise(function (e) {
                                i._reflowResolve = e
                            }) : null;
                            i._reflowPromise = s, i.start(r, t, n), i._interacting ? (i.move(a), i.end(o)) : i.stop();
                            return i.removePointer(o, o), i.pointerIsDown = !1, s
                        }(l, s, t, u, a)
                    }
                    p && p.push(r)
                }
                for (var c = lt.is.string(s.target) ? lt.arr.from(s._context.querySelectorAll(s.target)) : [s.target], f = lt.win.window.Promise, p = f ? [] : null, d = 0; d < c.length; d++) {
                    if ("break" === e()) break
                }
                return p && f.all(p).then(function () {
                    return s
                })
            }(this, e, n)
        }
    }
    Object.defineProperty(Us, "__esModule", {
        value: !0
    }), Us.install = Bs, Us.default = void 0;
    var Hs = {
        id: wn.EventPhase.Reflow = "reflow",
        install: Bs
    };
    Us.default = Hs;
    var $s = {};
    Object.defineProperty($s, "__esModule", {
        value: !0
    }), $s.default = $s.scope = $s.interact = void 0;
    var Ks = h({}),
        Qs = function (e) {
            if (e && e.__esModule) return e;
            var t = tu();
            if (t && t.has(e)) return t.get(e);
            var n = {};
            if (null != e) {
                var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
                for (var o in e)
                    if (Object.prototype.hasOwnProperty.call(e, o)) {
                        var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                        i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                    }
            }
            n.default = e, t && t.set(e, n);
            return n
        }(lt),
        Js = eu(M),
        Zs = eu(de);

    function eu(e) {
        return e && e.__esModule ? e : {
            default: e
        }
    }

    function tu() {
        if ("function" != typeof WeakMap) return null;
        var e = new WeakMap;
        return tu = function () {
            return e
        }, e
    }
    var nu = {},
        ru = new Ks.Scope;
    $s.scope = ru;

    function ou(e, t) {
        var n = ru.interactables.get(e, t);
        return n || ((n = ru.interactables.new(e, t)).events.global = nu), n
    }($s.interact = ou).use = function (e, t) {
        return ru.usePlugin(e, t), ou
    }, ou.isSet = function (e, t) {
        return !!ru.interactables.get(e, t && t.context)
    }, ou.on = function (e, t, n) {
        Qs.is.string(e) && -1 !== e.search(" ") && (e = e.trim().split(/ +/));
        if (Qs.is.array(e)) {
            for (var r = 0; r < e.length; r++) {
                var o;
                o = e[r], ou.on(o, t, n)
            }
            return ou
        }
        if (Qs.is.object(e)) {
            for (var i in e) ou.on(i, e[i], t);
            return ou
        }
        Qs.arr.contains(ru.actions.eventTypes, e) ? nu[e] ? nu[e].push(t) : nu[e] = [t] : Zs.default.add(ru.document, e, t, {
            options: n
        });
        return ou
    }, ou.off = function (e, t, n) {
        Qs.is.string(e) && -1 !== e.search(" ") && (e = e.trim().split(/ +/));
        if (Qs.is.array(e)) {
            for (var r = 0; r < e.length; r++) {
                var o;
                o = e[r], ou.off(o, t, n)
            }
            return ou
        }
        if (Qs.is.object(e)) {
            for (var i in e) ou.off(i, e[i], t);
            return ou
        }
        var a;
        Qs.arr.contains(ru.actions.eventTypes, e) ? e in nu && -1 !== (a = nu[e].indexOf(t)) && nu[e].splice(a, 1) : Zs.default.remove(ru.document, e, t, n);
        return ou
    }, ou.debug = function () {
        return ru
    }, ou.getPointerAverage = Qs.pointer.pointerAverage, ou.getTouchBBox = Qs.pointer.touchBBox, ou.getTouchDistance = Qs.pointer.touchDistance, ou.getTouchAngle = Qs.pointer.touchAngle, ou.getElementRect = Qs.dom.getElementRect, ou.getElementClientRect = Qs.dom.getElementClientRect, ou.matchesSelector = Qs.dom.matchesSelector, ou.closest = Qs.dom.closest, ou.supportsTouch = function () {
        return Js.default.supportsTouch
    }, ou.supportsPointerEvent = function () {
        return Js.default.supportsPointerEvent
    }, ou.stop = function () {
        for (var e = 0; e < ru.interactions.list.length; e++) {
            ru.interactions.list[e].stop()
        }
        return ou
    }, ou.pointerMoveTolerance = function (e) {
        if (Qs.is.number(e)) return ru.interactions.pointerMoveTolerance = e, ou;
        return ru.interactions.pointerMoveTolerance
    }, ru.interactables.signals.on("unset", function (e) {
        var t = e.interactable;
        ru.interactables.list.splice(ru.interactables.list.indexOf(t), 1);
        for (var n = 0; n < ru.interactions.list.length; n++) {
            var r = ru.interactions.list[n];
            r.interactable === t && r.interacting() && !r._ending && r.stop()
        }
    }), ou.addDocument = function (e, t) {
        return ru.addDocument(e, t)
    }, ou.removeDocument = function (e) {
        return ru.removeDocument(e)
    };
    var iu = ru.interact = ou;
    $s.default = iu;
    var au = {};
    Object.defineProperty(au, "__esModule", {
        value: !0
    }), au.init = function (e) {
        for (var t in hu.scope.init(e), hu.default.use(cu.default), hu.default.use(vu), hu.default.use(fu.default), hu.default.use(lu), hu.default.use(su), hu.default.use(du.default), pu) {
            var n = pu[t],
                r = n._defaults,
                o = n._methods;
            r._methods = o, hu.scope.defaults.perAction[t] = r
        }
        hu.default.use(uu.default), hu.default.use(gu.default), 0;
        return hu.default
    }, Object.defineProperty(au, "autoScroll", {
        enumerable: !0,
        get: function () {
            return uu.default
        }
    }), Object.defineProperty(au, "interactablePreventDefault", {
        enumerable: !0,
        get: function () {
            return cu.default
        }
    }), Object.defineProperty(au, "inertia", {
        enumerable: !0,
        get: function () {
            return fu.default
        }
    }), Object.defineProperty(au, "modifiers", {
        enumerable: !0,
        get: function () {
            return du.default
        }
    }), Object.defineProperty(au, "reflow", {
        enumerable: !0,
        get: function () {
            return gu.default
        }
    }), Object.defineProperty(au, "interact", {
        enumerable: !0,
        get: function () {
            return hu.default
        }
    }), au.pointerEvents = au.actions = au.default = void 0;
    var su = bu(Jr);
    au.actions = su;
    var uu = yu(oo),
        lu = bu($o),
        cu = yu(ei),
        fu = (yu(li), yu(Ai)),
        pu = bu(Va),
        du = yu(hi),
        vu = bu(Fs);
    au.pointerEvents = vu;
    var gu = yu(Us),
        hu = bu($s);

    function yu(e) {
        return e && e.__esModule ? e : {
            default: e
        }
    }

    function mu() {
        if ("function" != typeof WeakMap) return null;
        var e = new WeakMap;
        return mu = function () {
            return e
        }, e
    }

    function bu(e) {
        if (e && e.__esModule) return e;
        var t = mu();
        if (t && t.has(e)) return t.get(e);
        var n = {};
        if (null != e) {
            var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
            for (var o in e)
                if (Object.prototype.hasOwnProperty.call(e, o)) {
                    var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                    i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                }
        }
        return n.default = e, t && t.set(e, n), n
    }
    hu.default.version = "1.6.3";
    var wu = hu.default;
    au.default = wu;
    var Ou = {};

    function Pu(e, t) {
        return function (e) {
            if (Array.isArray(e)) return e
        }(e) || function (e, t) {
            if (!(Symbol.iterator in Object(e) || "[object Arguments]" === Object.prototype.toString.call(e))) return;
            var n = [],
                r = !0,
                o = !1,
                i = void 0;
            try {
                for (var a, s = e[Symbol.iterator](); !(r = (a = s.next()).done) && (n.push(a.value), !t || n.length !== t); r = !0);
            } catch (e) {
                o = !0, i = e
            } finally {
                try {
                    r || null == s.return || s.return()
                } finally {
                    if (o) throw i
                }
            }
            return n
        }(e, t) || function () {
            throw new TypeError("Invalid attempt to destructure non-iterable instance")
        }()
    }
    Object.defineProperty(Ou, "__esModule", {
        value: !0
    }), Ou.default = void 0;

    function _u(v) {
        var g = [
            ["x", "y"],
            ["left", "top"],
            ["right", "bottom"],
            ["width", "height"]
        ].filter(function (e) {
            var t = Pu(e, 2),
                n = t[0],
                r = t[1];
            return n in v || r in v
        });
        return function (e, t) {
            for (var n = v.range, r = v.limits, o = void 0 === r ? {
                    left: -1 / 0,
                    right: 1 / 0,
                    top: -1 / 0,
                    bottom: 1 / 0
                } : r, i = v.offset, a = void 0 === i ? {
                    x: 0,
                    y: 0
                } : i, s = {
                    range: n
                }, u = 0; u < g.length; u++) {
                var l = Pu(g[u], 2),
                    c = l[0],
                    f = l[1],
                    p = Math.round((e - a.x) / v[c]),
                    d = Math.round((t - a.y) / v[f]);
                s[c] = Math.max(o.left, Math.min(o.right, p * v[c] + a.x)), s[f] = Math.max(o.top, Math.min(o.bottom, d * v[f] + a.y))
            }
            return s
        }
    }
    Ou.default = _u;
    var xu = {};
    Object.defineProperty(xu, "__esModule", {
        value: !0
    }), Object.defineProperty(xu, "grid", {
        enumerable: !0,
        get: function () {
            return Mu.default
        }
    });
    var ju, Mu = (ju = Ou) && ju.__esModule ? ju : {
        default: ju
    };
    var Eu = {
        exports: {}
    };
    Object.defineProperty(Eu.exports, "__esModule", {
        value: !0
    }), Eu.exports.init = Ru, Eu.exports.default = void 0;
    var Su, ku = Au(au),
        Tu = Au(Va),
        Du = (Su = Ce) && Su.__esModule ? Su : {
            default: Su
        },
        Iu = Au(xu);

    function zu() {
        if ("function" != typeof WeakMap) return null;
        var e = new WeakMap;
        return zu = function () {
            return e
        }, e
    }

    function Au(e) {
        if (e && e.__esModule) return e;
        var t = zu();
        if (t && t.has(e)) return t.get(e);
        var n = {};
        if (null != e) {
            var r = Object.defineProperty && Object.getOwnPropertyDescriptor;
            for (var o in e)
                if (Object.prototype.hasOwnProperty.call(e, o)) {
                    var i = r ? Object.getOwnPropertyDescriptor(e, o) : null;
                    i && (i.get || i.set) ? Object.defineProperty(n, o, i) : n[o] = e[o]
                }
        }
        return n.default = e, t && t.set(e, n), n
    }

    function Cu(e) {
        return (Cu = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
            return typeof e
        } : function (e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
        })(e)
    }

    function Ru(e) {
        return (0, ku.init)(e), ku.default.use({
            id: "interactjs",
            install: function () {
                ku.default.modifiers = (0, Du.default)({}, Tu), ku.default.snappers = Iu, ku.default.createSnapGrid = ku.default.snappers.grid
            }
        })
    }
    "object" === ("undefined" == typeof window ? "undefined" : Cu(window)) && window && Ru(window);
    var Wu = ku.default;
    return Eu.exports.default = Wu, ku.default.default = ku.default, ku.default.init = Ru, "object" === Cu(Eu) && Eu && (Eu.exports = ku.default), Eu = Eu.exports
});

//# sourceMappingURL=interact.min.js.map
