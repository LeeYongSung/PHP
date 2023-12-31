/*
	Copyright (c) 2004-2011, The Dojo Foundation All Rights Reserved.
	Available via Academic Free License >= 2.1 OR the modified BSD license.
	see: http://dojotoolkit.org/license for details
*/

/*
	This is an optimized version of Dojo, built for deployment and not for
	development. To get sources and documentation, please visit:

		http://dojotoolkit.org
*/

//>>built
require({
    cache: {
        "dojox/gfx/path": function() {
            define(["./_base", "dojo/_base/lang", "dojo/_base/declare", "./matrix", "./shape"], function(b, q, p, s, n) {
                n = p("dojox.gfx.path.Path", n.Shape, {
                    constructor: function(h) {
                        this.shape = q.clone(b.defaultPath);
                        this.segments = [];
                        this.tbbox = null;
                        this.absolute = !0;
                        this.last = {};
                        this.rawNode = h;
                        this.segmented = !1
                    },
                    setAbsoluteMode: function(h) {
                        this._confirmSegmented();
                        this.absolute = "string" == typeof h ? "absolute" == h : h;
                        return this
                    },
                    getAbsoluteMode: function() {
                        this._confirmSegmented();
                        return this.absolute
                    },
                    getBoundingBox: function() {
                        this._confirmSegmented();
                        return this.bbox && "l"in this.bbox ? {
                            x: this.bbox.l,
                            y: this.bbox.t,
                            width: this.bbox.r - this.bbox.l,
                            height: this.bbox.b - this.bbox.t
                        } : null
                    },
                    _getRealBBox: function() {
                        this._confirmSegmented();
                        if (this.tbbox)
                            return this.tbbox;
                        var h = this.bbox
                          , b = this._getRealMatrix();
                        this.bbox = null;
                        for (var d = 0, k = this.segments.length; d < k; ++d)
                            this._updateWithSegment(this.segments[d], b);
                        b = this.bbox;
                        this.bbox = h;
                        return this.tbbox = b ? [{
                            x: b.l,
                            y: b.t
                        }, {
                            x: b.r,
                            y: b.t
                        }, {
                            x: b.r,
                            y: b.b
                        }, {
                            x: b.l,
                            y: b.b
                        }] : null
                    },
                    getLastPosition: function() {
                        this._confirmSegmented();
                        return "x"in this.last ? this.last : null
                    },
                    _applyTransform: function() {
                        this.tbbox = null;
                        return this.inherited(arguments)
                    },
                    _updateBBox: function(h, b, d) {
                        d && (b = s.multiplyPoint(d, h, b),
                        h = b.x,
                        b = b.y);
                        this.bbox && "l"in this.bbox ? (this.bbox.l > h && (this.bbox.l = h),
                        this.bbox.r < h && (this.bbox.r = h),
                        this.bbox.t > b && (this.bbox.t = b),
                        this.bbox.b < b && (this.bbox.b = b)) : this.bbox = {
                            l: h,
                            b: b,
                            r: h,
                            t: b
                        }
                    },
                    _updateWithSegment: function(h, l) {
                        var d = h.args, k = d.length, c;
                        switch (h.action) {
                        case "M":
                        case "L":
                        case "C":
                        case "S":
                        case "Q":
                        case "T":
                            for (c = 0; c < k; c += 2)
                                this._updateBBox(d[c], d[c + 1], l);
                            this.last.x = d[k - 2];
                            this.last.y = d[k - 1];
                            this.absolute = !0;
                            break;
                        case "H":
                            for (c = 0; c < k; ++c)
                                this._updateBBox(d[c], this.last.y, l);
                            this.last.x = d[k - 1];
                            this.absolute = !0;
                            break;
                        case "V":
                            for (c = 0; c < k; ++c)
                                this._updateBBox(this.last.x, d[c], l);
                            this.last.y = d[k - 1];
                            this.absolute = !0;
                            break;
                        case "m":
                            c = 0;
                            "x"in this.last || (this._updateBBox(this.last.x = d[0], this.last.y = d[1], l),
                            c = 2);
                            for (; c < k; c += 2)
                                this._updateBBox(this.last.x += d[c], this.last.y += d[c + 1], l);
                            this.absolute = !1;
                            break;
                        case "l":
                        case "t":
                            for (c = 0; c < k; c += 2)
                                this._updateBBox(this.last.x += d[c], this.last.y += d[c + 1], l);
                            this.absolute = !1;
                            break;
                        case "h":
                            for (c = 0; c < k; ++c)
                                this._updateBBox(this.last.x += d[c], this.last.y, l);
                            this.absolute = !1;
                            break;
                        case "v":
                            for (c = 0; c < k; ++c)
                                this._updateBBox(this.last.x, this.last.y += d[c], l);
                            this.absolute = !1;
                            break;
                        case "c":
                            for (c = 0; c < k; c += 6)
                                this._updateBBox(this.last.x + d[c], this.last.y + d[c + 1], l),
                                this._updateBBox(this.last.x + d[c + 2], this.last.y + d[c + 3], l),
                                this._updateBBox(this.last.x += d[c + 4], this.last.y += d[c + 5], l);
                            this.absolute = !1;
                            break;
                        case "s":
                        case "q":
                            for (c = 0; c < k; c += 4)
                                this._updateBBox(this.last.x + d[c], this.last.y + d[c + 1], l),
                                this._updateBBox(this.last.x += d[c + 2], this.last.y += d[c + 3], l);
                            this.absolute = !1;
                            break;
                        case "A":
                            for (c = 0; c < k; c += 7)
                                this._updateBBox(d[c + 5], d[c + 6], l);
                            this.last.x = d[k - 2];
                            this.last.y = d[k - 1];
                            this.absolute = !0;
                            break;
                        case "a":
                            for (c = 0; c < k; c += 7)
                                this._updateBBox(this.last.x += d[c + 5], this.last.y += d[c + 6], l);
                            this.absolute = !1
                        }
                        var e = [h.action];
                        for (c = 0; c < k; ++c)
                            e.push(b.formatNumber(d[c], !0));
                        if ("string" == typeof this.shape.path)
                            this.shape.path += e.join("");
                        else {
                            c = 0;
                            for (k = e.length; c < k; ++c)
                                this.shape.path.push(e[c])
                        }
                    },
                    _validSegments: {
                        m: 2,
                        l: 2,
                        h: 1,
                        v: 1,
                        c: 6,
                        s: 4,
                        q: 4,
                        t: 2,
                        a: 7,
                        z: 0
                    },
                    _pushSegment: function(b, l) {
                        this.tbbox = null;
                        var d = this._validSegments[b.toLowerCase()];
                        "number" == typeof d && (d ? l.length >= d && (d = {
                            action: b,
                            args: l.slice(0, l.length - l.length % d)
                        },
                        this.segments.push(d),
                        this._updateWithSegment(d)) : (d = {
                            action: b,
                            args: []
                        },
                        this.segments.push(d),
                        this._updateWithSegment(d)))
                    },
                    _collectArgs: function(b, l) {
                        for (var d = 0; d < l.length; ++d) {
                            var k = l[d];
                            "boolean" == typeof k ? b.push(k ? 1 : 0) : "number" == typeof k ? b.push(k) : k instanceof Array ? this._collectArgs(b, k) : "x"in k && "y"in k && b.push(k.x, k.y)
                        }
                    },
                    moveTo: function() {
                        this._confirmSegmented();
                        var b = [];
                        this._collectArgs(b, arguments);
                        this._pushSegment(this.absolute ? "M" : "m", b);
                        return this
                    },
                    lineTo: function() {
                        this._confirmSegmented();
                        var b = [];
                        this._collectArgs(b, arguments);
                        this._pushSegment(this.absolute ? "L" : "l", b);
                        return this
                    },
                    hLineTo: function() {
                        this._confirmSegmented();
                        var b = [];
                        this._collectArgs(b, arguments);
                        this._pushSegment(this.absolute ? "H" : "h", b);
                        return this
                    },
                    vLineTo: function() {
                        this._confirmSegmented();
                        var b = [];
                        this._collectArgs(b, arguments);
                        this._pushSegment(this.absolute ? "V" : "v", b);
                        return this
                    },
                    curveTo: function() {
                        this._confirmSegmented();
                        var b = [];
                        this._collectArgs(b, arguments);
                        this._pushSegment(this.absolute ? "C" : "c", b);
                        return this
                    },
                    smoothCurveTo: function() {
                        this._confirmSegmented();
                        var b = [];
                        this._collectArgs(b, arguments);
                        this._pushSegment(this.absolute ? "S" : "s", b);
                        return this
                    },
                    qCurveTo: function() {
                        this._confirmSegmented();
                        var b = [];
                        this._collectArgs(b, arguments);
                        this._pushSegment(this.absolute ? "Q" : "q", b);
                        return this
                    },
                    qSmoothCurveTo: function() {
                        this._confirmSegmented();
                        var b = [];
                        this._collectArgs(b, arguments);
                        this._pushSegment(this.absolute ? "T" : "t", b);
                        return this
                    },
                    arcTo: function() {
                        this._confirmSegmented();
                        var b = [];
                        this._collectArgs(b, arguments);
                        this._pushSegment(this.absolute ? "A" : "a", b);
                        return this
                    },
                    closePath: function() {
                        this._confirmSegmented();
                        this._pushSegment("Z", []);
                        return this
                    },
                    _confirmSegmented: function() {
                        if (!this.segmented) {
                            var b = this.shape.path;
                            this.shape.path = [];
                            this._setPath(b);
                            this.shape.path = this.shape.path.join("");
                            this.segmented = !0
                        }
                    },
                    _setPath: function(h) {
                        h = q.isArray(h) ? h : h.match(b.pathSvgRegExp);
                        this.segments = [];
                        this.absolute = !0;
                        this.bbox = {};
                        this.last = {};
                        if (h) {
                            for (var l = "", d = [], k = h.length, c = 0; c < k; ++c) {
                                var e = h[c]
                                  , a = parseFloat(e);
                                isNaN(a) ? (l && this._pushSegment(l, d),
                                d = [],
                                l = e) : d.push(a)
                            }
                            this._pushSegment(l, d)
                        }
                    },
                    setShape: function(h) {
                        this.inherited(arguments, ["string" == typeof h ? {
                            path: h
                        } : h]);
                        this.segmented = !1;
                        this.segments = [];
                        b.lazyPathSegmentation || this._confirmSegmented();
                        return this
                    },
                    _2PI: 2 * Math.PI
                });
                p = p("dojox.gfx.path.TextPath", n, {
                    constructor: function(h) {
                        "text"in this || (this.text = q.clone(b.defaultTextPath));
                        "fontStyle"in this || (this.fontStyle = q.clone(b.defaultFont))
                    },
                    getText: function() {
                        return this.text
                    },
                    setText: function(h) {
                        this.text = b.makeParameters(this.text, "string" == typeof h ? {
                            text: h
                        } : h);
                        this._setText();
                        return this
                    },
                    getFont: function() {
                        return this.fontStyle
                    },
                    setFont: function(h) {
                        this.fontStyle = "string" == typeof h ? b.splitFontString(h) : b.makeParameters(b.defaultFont, h);
                        this._setFont();
                        return this
                    }
                });
                return b.path = {
                    Path: n,
                    TextPath: p
                }
            })
        },
        "dojox/gfx/shape": function() {
            define("./_base dojo/_base/lang dojo/_base/declare dojo/_base/kernel dojo/_base/sniff dojo/on dojo/_base/array dojo/dom-construct dojo/_base/Color ./matrix".split(" "), function(b, q, p, s, n, h, l, d, k, c) {
                var e = b.shape = {};
                e.Shape = p("dojox.gfx.shape.Shape", null, {
                    constructor: function() {
                        this.parentMatrix = this.parent = this.bbox = this.strokeStyle = this.fillStyle = this.matrix = this.shape = this.rawNode = null;
                        if (n("gfxRegistry")) {
                            var a = e.register(this);
                            this.getUID = function() {
                                return a
                            }
                        }
                    },
                    destroy: function() {
                        n("gfxRegistry") && e.dispose(this);
                        this.rawNode && "__gfxObject__"in this.rawNode && (this.rawNode.__gfxObject__ = null);
                        this.rawNode = null
                    },
                    getNode: function() {
                        return this.rawNode
                    },
                    getShape: function() {
                        return this.shape
                    },
                    getTransform: function() {
                        return this.matrix
                    },
                    getFill: function() {
                        return this.fillStyle
                    },
                    getStroke: function() {
                        return this.strokeStyle
                    },
                    getParent: function() {
                        return this.parent
                    },
                    getBoundingBox: function() {
                        return this.bbox
                    },
                    getTransformedBoundingBox: function() {
                        var a = this.getBoundingBox();
                        if (!a)
                            return null;
                        var b = this._getRealMatrix();
                        return [c.multiplyPoint(b, a.x, a.y), c.multiplyPoint(b, a.x + a.width, a.y), c.multiplyPoint(b, a.x + a.width, a.y + a.height), c.multiplyPoint(b, a.x, a.y + a.height)]
                    },
                    getEventSource: function() {
                        return this.rawNode
                    },
                    setClip: function(a) {
                        this.clip = a
                    },
                    getClip: function() {
                        return this.clip
                    },
                    setShape: function(a) {
                        this.shape = b.makeParameters(this.shape, a);
                        this.bbox = null;
                        return this
                    },
                    setFill: function(a) {
                        if (!a)
                            return this.fillStyle = null,
                            this;
                        var c = null;
                        if ("object" == typeof a && "type"in a)
                            switch (a.type) {
                            case "linear":
                                c = b.makeParameters(b.defaultLinearGradient, a);
                                break;
                            case "radial":
                                c = b.makeParameters(b.defaultRadialGradient, a);
                                break;
                            case "pattern":
                                c = b.makeParameters(b.defaultPattern, a)
                            }
                        else
                            c = b.normalizeColor(a);
                        this.fillStyle = c;
                        return this
                    },
                    setStroke: function(a) {
                        if (!a)
                            return this.strokeStyle = null,
                            this;
                        if ("string" == typeof a || q.isArray(a) || a instanceof k)
                            a = {
                                color: a
                            };
                        a = this.strokeStyle = b.makeParameters(b.defaultStroke, a);
                        a.color = b.normalizeColor(a.color);
                        return this
                    },
                    setTransform: function(a) {
                        this.matrix = c.clone(a ? c.normalize(a) : c.identity);
                        return this._applyTransform()
                    },
                    _applyTransform: function() {
                        return this
                    },
                    moveToFront: function() {
                        var a = this.getParent();
                        a && (a._moveChildToFront(this),
                        this._moveToFront());
                        return this
                    },
                    moveToBack: function() {
                        var a = this.getParent();
                        a && (a._moveChildToBack(this),
                        this._moveToBack());
                        return this
                    },
                    _moveToFront: function() {},
                    _moveToBack: function() {},
                    applyRightTransform: function(a) {
                        return a ? this.setTransform([this.matrix, a]) : this
                    },
                    applyLeftTransform: function(a) {
                        return a ? this.setTransform([a, this.matrix]) : this
                    },
                    applyTransform: function(a) {
                        return a ? this.setTransform([this.matrix, a]) : this
                    },
                    removeShape: function(a) {
                        this.parent && this.parent.remove(this, a);
                        return this
                    },
                    _setParent: function(a, b) {
                        this.parent = a;
                        return this._updateParentMatrix(b)
                    },
                    _updateParentMatrix: function(a) {
                        this.parentMatrix = a ? c.clone(a) : null;
                        return this._applyTransform()
                    },
                    _getRealMatrix: function() {
                        for (var a = this.matrix, b = this.parent; b; )
                            b.matrix && (a = c.multiply(b.matrix, a)),
                            b = b.parent;
                        return a
                    }
                });
                e._eventsProcessing = {
                    on: function(a, c) {
                        return h(this.getEventSource(), a, e.fixCallback(this, b.fixTarget, c))
                    },
                    connect: function(a, b, c) {
                        "on" == a.substring(0, 2) && (a = a.substring(2));
                        return this.on(a, c ? q.hitch(b, c) : b)
                    },
                    disconnect: function(a) {
                        return a.remove()
                    }
                };
                e.fixCallback = function(a, b, c, f) {
                    f || (f = c,
                    c = null);
                    if (q.isString(f)) {
                        c = c || s.global;
                        if (!c[f])
                            throw ['dojox.gfx.shape.fixCallback: scope["', f, '"] is null (scope\x3d"', c, '")'].join("");
                        return function(d) {
                            return b(d, a) ? c[f].apply(c, arguments || []) : void 0
                        }
                    }
                    return !c ? function(d) {
                        return b(d, a) ? f.apply(c, arguments) : void 0
                    }
                    : function(d) {
                        return b(d, a) ? f.apply(c, arguments || []) : void 0
                    }
                }
                ;
                q.extend(e.Shape, e._eventsProcessing);
                e.Container = {
                    _init: function() {
                        this.children = [];
                        this._batch = 0
                    },
                    openBatch: function() {
                        return this
                    },
                    closeBatch: function() {
                        return this
                    },
                    add: function(a) {
                        var b = a.getParent();
                        b && b.remove(a, !0);
                        this.children.push(a);
                        return a._setParent(this, this._getRealMatrix())
                    },
                    remove: function(a, b) {
                        for (var c = 0; c < this.children.length; ++c)
                            if (this.children[c] == a) {
                                b || (a.parent = null,
                                a.parentMatrix = null);
                                this.children.splice(c, 1);
                                break
                            }
                        return this
                    },
                    clear: function(a) {
                        for (var b, c = 0; c < this.children.length; ++c)
                            b = this.children[c],
                            b.parent = null,
                            b.parentMatrix = null,
                            a && b.destroy();
                        this.children = [];
                        return this
                    },
                    getBoundingBox: function() {
                        if (this.children) {
                            var a = null;
                            l.forEach(this.children, function(b) {
                                var d = b.getBoundingBox();
                                d && ((b = b.getTransform()) && (d = c.multiplyRectangle(b, d)),
                                a ? (a.x = Math.min(a.x, d.x),
                                a.y = Math.min(a.y, d.y),
                                a.endX = Math.max(a.endX, d.x + d.width),
                                a.endY = Math.max(a.endY, d.y + d.height)) : a = {
                                    x: d.x,
                                    y: d.y,
                                    endX: d.x + d.width,
                                    endY: d.y + d.height
                                })
                            });
                            a && (a.width = a.endX - a.x,
                            a.height = a.endY - a.y);
                            return a
                        }
                        return null
                    },
                    _moveChildToFront: function(a) {
                        for (var b = 0; b < this.children.length; ++b)
                            if (this.children[b] == a) {
                                this.children.splice(b, 1);
                                this.children.push(a);
                                break
                            }
                        return this
                    },
                    _moveChildToBack: function(a) {
                        for (var b = 0; b < this.children.length; ++b)
                            if (this.children[b] == a) {
                                this.children.splice(b, 1);
                                this.children.unshift(a);
                                break
                            }
                        return this
                    }
                };
                e.Surface = p("dojox.gfx.shape.Surface", null, {
                    constructor: function() {
                        this._parent = this.rawNode = null;
                        this._nodes = [];
                        this._events = []
                    },
                    destroy: function() {
                        l.forEach(this._nodes, d.destroy);
                        this._nodes = [];
                        l.forEach(this._events, function(a) {
                            a && a.remove()
                        });
                        this._events = [];
                        this.rawNode = null;
                        if (n("ie"))
                            for (; this._parent.lastChild; )
                                d.destroy(this._parent.lastChild);
                        else
                            this._parent.innerHTML = "";
                        this._parent = null
                    },
                    getEventSource: function() {
                        return this.rawNode
                    },
                    _getRealMatrix: function() {
                        return null
                    },
                    isLoaded: !0,
                    onLoad: function(a) {},
                    whenLoaded: function(a, b) {
                        var c = q.hitch(a, b);
                        if (this.isLoaded)
                            c(this);
                        else
                            h.once(this, "load", function(a) {
                                c(a)
                            })
                    }
                });
                q.extend(e.Surface, e._eventsProcessing);
                e.Rect = p("dojox.gfx.shape.Rect", e.Shape, {
                    constructor: function(a) {
                        this.shape = b.getDefault("Rect");
                        this.rawNode = a
                    },
                    getBoundingBox: function() {
                        return this.shape
                    }
                });
                e.Ellipse = p("dojox.gfx.shape.Ellipse", e.Shape, {
                    constructor: function(a) {
                        this.shape = b.getDefault("Ellipse");
                        this.rawNode = a
                    },
                    getBoundingBox: function() {
                        if (!this.bbox) {
                            var a = this.shape;
                            this.bbox = {
                                x: a.cx - a.rx,
                                y: a.cy - a.ry,
                                width: 2 * a.rx,
                                height: 2 * a.ry
                            }
                        }
                        return this.bbox
                    }
                });
                e.Circle = p("dojox.gfx.shape.Circle", e.Shape, {
                    constructor: function(a) {
                        this.shape = b.getDefault("Circle");
                        this.rawNode = a
                    },
                    getBoundingBox: function() {
                        if (!this.bbox) {
                            var a = this.shape;
                            this.bbox = {
                                x: a.cx - a.r,
                                y: a.cy - a.r,
                                width: 2 * a.r,
                                height: 2 * a.r
                            }
                        }
                        return this.bbox
                    }
                });
                e.Line = p("dojox.gfx.shape.Line", e.Shape, {
                    constructor: function(a) {
                        this.shape = b.getDefault("Line");
                        this.rawNode = a
                    },
                    getBoundingBox: function() {
                        if (!this.bbox) {
                            var a = this.shape;
                            this.bbox = {
                                x: Math.min(a.x1, a.x2),
                                y: Math.min(a.y1, a.y2),
                                width: Math.abs(a.x2 - a.x1),
                                height: Math.abs(a.y2 - a.y1)
                            }
                        }
                        return this.bbox
                    }
                });
                e.Polyline = p("dojox.gfx.shape.Polyline", e.Shape, {
                    constructor: function(a) {
                        this.shape = b.getDefault("Polyline");
                        this.rawNode = a
                    },
                    setShape: function(a, b) {
                        a && a instanceof Array ? (this.inherited(arguments, [{
                            points: a
                        }]),
                        b && this.shape.points.length && this.shape.points.push(this.shape.points[0])) : this.inherited(arguments, [a]);
                        return this
                    },
                    _normalizePoints: function() {
                        var a = this.shape.points
                          , b = a && a.length;
                        if (b && "number" == typeof a[0]) {
                            for (var c = [], f = 0; f < b; f += 2)
                                c.push({
                                    x: a[f],
                                    y: a[f + 1]
                                });
                            this.shape.points = c
                        }
                    },
                    getBoundingBox: function() {
                        if (!this.bbox && this.shape.points.length) {
                            for (var a = this.shape.points, b = a.length, c = a[0], f = c.x, d = c.y, e = c.x, h = c.y, k = 1; k < b; ++k)
                                c = a[k],
                                f > c.x && (f = c.x),
                                e < c.x && (e = c.x),
                                d > c.y && (d = c.y),
                                h < c.y && (h = c.y);
                            this.bbox = {
                                x: f,
                                y: d,
                                width: e - f,
                                height: h - d
                            }
                        }
                        return this.bbox
                    }
                });
                e.Image = p("dojox.gfx.shape.Image", e.Shape, {
                    constructor: function(a) {
                        this.shape = b.getDefault("Image");
                        this.rawNode = a
                    },
                    getBoundingBox: function() {
                        return this.shape
                    },
                    setStroke: function() {
                        return this
                    },
                    setFill: function() {
                        return this
                    }
                });
                e.Text = p(e.Shape, {
                    constructor: function(a) {
                        this.fontStyle = null;
                        this.shape = b.getDefault("Text");
                        this.rawNode = a
                    },
                    getFont: function() {
                        return this.fontStyle
                    },
                    setFont: function(a) {
                        this.fontStyle = "string" == typeof a ? b.splitFontString(a) : b.makeParameters(b.defaultFont, a);
                        this._setFont();
                        return this
                    },
                    getBoundingBox: function() {
                        var a = null;
                        this.getShape().text && (a = b._base._computeTextBoundingBox(this));
                        return a
                    }
                });
                e.Creator = {
                    createShape: function(a) {
                        switch (a.type) {
                        case b.defaultPath.type:
                            return this.createPath(a);
                        case b.defaultRect.type:
                            return this.createRect(a);
                        case b.defaultCircle.type:
                            return this.createCircle(a);
                        case b.defaultEllipse.type:
                            return this.createEllipse(a);
                        case b.defaultLine.type:
                            return this.createLine(a);
                        case b.defaultPolyline.type:
                            return this.createPolyline(a);
                        case b.defaultImage.type:
                            return this.createImage(a);
                        case b.defaultText.type:
                            return this.createText(a);
                        case b.defaultTextPath.type:
                            return this.createTextPath(a)
                        }
                        return null
                    },
                    createGroup: function() {
                        return this.createObject(b.Group)
                    },
                    createRect: function(a) {
                        return this.createObject(b.Rect, a)
                    },
                    createEllipse: function(a) {
                        return this.createObject(b.Ellipse, a)
                    },
                    createCircle: function(a) {
                        return this.createObject(b.Circle, a)
                    },
                    createLine: function(a) {
                        return this.createObject(b.Line, a)
                    },
                    createPolyline: function(a) {
                        return this.createObject(b.Polyline, a)
                    },
                    createImage: function(a) {
                        return this.createObject(b.Image, a)
                    },
                    createText: function(a) {
                        return this.createObject(b.Text, a)
                    },
                    createPath: function(a) {
                        return this.createObject(b.Path, a)
                    },
                    createTextPath: function(a) {
                        return this.createObject(b.TextPath, {}).setText(a)
                    },
                    createObject: function(a, b) {
                        return null
                    }
                };
                return e
            })
        },
        "*noref": 1
    }
});
define("dojox/gfx/svg", "dojo/_base/lang dojo/_base/sniff dojo/_base/window dojo/dom dojo/_base/declare dojo/_base/array dojo/dom-geometry dojo/dom-attr dojo/_base/Color ./_base ./shape ./path".split(" "), function(b, q, p, s, n, h, l, d, k, c, e, a) {
    function r(g, a) {
        return p.doc.createElementNS ? p.doc.createElementNS(g, a) : p.doc.createElement(a)
    }
    function u(g) {
        return f.useSvgWeb ? p.doc.createTextNode(g, !0) : p.doc.createTextNode(g)
    }
    var f = c.svg = {};
    f.useSvgWeb = "undefined" != typeof window.svgweb;
    var w = navigator.userAgent
      , x = q("ios")
      , v = q("android")
      , y = q("chrome") || v && 4 <= v ? "auto" : "optimizeLegibility";
    f.xmlns = {
        xlink: "http://www.w3.org/1999/xlink",
        svg: "http://www.w3.org/2000/svg"
    };
    f.getRef = function(g) {
        return !g || "none" == g ? null : g.match(/^url\(#.+\)$/) ? s.byId(g.slice(5, -1)) : g.match(/^#dojoUnique\d+$/) ? s.byId(g.slice(1)) : null
    }
    ;
    f.dasharray = {
        solid: "none",
        shortdash: [4, 1],
        shortdot: [1, 1],
        shortdashdot: [4, 1, 1, 1],
        shortdashdotdot: [4, 1, 1, 1, 1, 1],
        dot: [1, 3],
        dash: [4, 3],
        longdash: [8, 3],
        dashdot: [4, 3, 1, 3],
        longdashdot: [8, 3, 1, 3],
        longdashdotdot: [8, 3, 1, 3, 1, 3]
    };
    var z = 0;
    f.Shape = n("dojox.gfx.svg.Shape", e.Shape, {
        destroy: function() {
            if (this.fillStyle && "type"in this.fillStyle) {
                var g = this.rawNode.getAttribute("fill");
                (g = f.getRef(g)) && g.parentNode.removeChild(g)
            }
            if (this.clip && (g = this.rawNode.getAttribute("clip-path")))
                (g = s.byId(g.match(/gfx_clip[\d]+/)[0])) && g.parentNode.removeChild(g);
            e.Shape.prototype.destroy.apply(this, arguments)
        },
        setFill: function(g) {
            if (!g)
                return this.fillStyle = null,
                this.rawNode.setAttribute("fill", "none"),
                this.rawNode.setAttribute("fill-opacity", 0),
                this;
            var a, b = function(g) {
                this.setAttribute(g, a[g].toFixed(8))
            };
            if ("object" == typeof g && "type"in g) {
                switch (g.type) {
                case "linear":
                    a = c.makeParameters(c.defaultLinearGradient, g);
                    g = this._setFillObject(a, "linearGradient");
                    h.forEach(["x1", "y1", "x2", "y2"], b, g);
                    break;
                case "radial":
                    a = c.makeParameters(c.defaultRadialGradient, g);
                    g = this._setFillObject(a, "radialGradient");
                    h.forEach(["cx", "cy", "r"], b, g);
                    break;
                case "pattern":
                    a = c.makeParameters(c.defaultPattern, g),
                    g = this._setFillObject(a, "pattern"),
                    h.forEach(["x", "y", "width", "height"], b, g)
                }
                this.fillStyle = a;
                return this
            }
            this.fillStyle = a = c.normalizeColor(g);
            this.rawNode.setAttribute("fill", a.toCss());
            this.rawNode.setAttribute("fill-opacity", a.a);
            this.rawNode.setAttribute("fill-rule", "evenodd");
            return this
        },
        setStroke: function(g) {
            var a = this.rawNode;
            if (!g)
                return this.strokeStyle = null,
                a.setAttribute("stroke", "none"),
                a.setAttribute("stroke-opacity", 0),
                this;
            if ("string" == typeof g || b.isArray(g) || g instanceof k)
                g = {
                    color: g
                };
            g = this.strokeStyle = c.makeParameters(c.defaultStroke, g);
            g.color = c.normalizeColor(g.color);
            if (g) {
                a.setAttribute("stroke", g.color.toCss());
                a.setAttribute("stroke-opacity", g.color.a);
                a.setAttribute("stroke-width", g.width);
                a.setAttribute("stroke-linecap", g.cap);
                "number" == typeof g.join ? (a.setAttribute("stroke-linejoin", "miter"),
                a.setAttribute("stroke-miterlimit", g.join)) : a.setAttribute("stroke-linejoin", g.join);
                var d = g.style.toLowerCase();
                d in f.dasharray && (d = f.dasharray[d]);
                if (d instanceof Array) {
                    var d = b._toArray(d), m;
                    for (m = 0; m < d.length; ++m)
                        d[m] *= g.width;
                    if ("butt" != g.cap) {
                        for (m = 0; m < d.length; m += 2)
                            d[m] -= g.width,
                            1 > d[m] && (d[m] = 1);
                        for (m = 1; m < d.length; m += 2)
                            d[m] += g.width
                    }
                    d = d.join(",")
                }
                a.setAttribute("stroke-dasharray", d);
                a.setAttribute("dojoGfxStrokeStyle", g.style)
            }
            return this
        },
        _getParentSurface: function() {
            for (var g = this.parent; g && !(g instanceof c.Surface); g = g.parent)
                ;
            return g
        },
        _setFillObject: function(g, a) {
            var b = f.xmlns.svg;
            this.fillStyle = g;
            var d = this._getParentSurface().defNode
              , e = this.rawNode.getAttribute("fill");
            if (e = f.getRef(e))
                if (e.tagName.toLowerCase() != a.toLowerCase()) {
                    var h = e.id;
                    e.parentNode.removeChild(e);
                    e = r(b, a);
                    e.setAttribute("id", h);
                    d.appendChild(e)
                } else
                    for (; e.childNodes.length; )
                        e.removeChild(e.lastChild);
            else
                e = r(b, a),
                e.setAttribute("id", c._base._getUniqueId()),
                d.appendChild(e);
            if ("pattern" == a)
                e.setAttribute("patternUnits", "userSpaceOnUse"),
                b = r(b, "image"),
                b.setAttribute("x", 0),
                b.setAttribute("y", 0),
                b.setAttribute("width", g.width.toFixed(8)),
                b.setAttribute("height", g.height.toFixed(8)),
                b.setAttributeNS ? b.setAttributeNS(f.xmlns.xlink, "xlink:href", g.src) : b.setAttribute("xlink:href", g.src),
                e.appendChild(b);
            else {
                e.setAttribute("gradientUnits", "userSpaceOnUse");
                for (d = 0; d < g.colors.length; ++d) {
                    var h = g.colors[d]
                      , k = r(b, "stop")
                      , l = h.color = c.normalizeColor(h.color);
                    k.setAttribute("offset", h.offset.toFixed(8));
                    k.setAttribute("stop-color", l.toCss());
                    k.setAttribute("stop-opacity", l.a);
                    e.appendChild(k)
                }
            }
            this.rawNode.setAttribute("fill", "url(#" + e.getAttribute("id") + ")");
            this.rawNode.removeAttribute("fill-opacity");
            this.rawNode.setAttribute("fill-rule", "evenodd");
            return e
        },
        _applyTransform: function() {
            if (this.matrix) {
                var a = this.matrix;
                this.rawNode.setAttribute("transform", "matrix(" + a.xx.toFixed(8) + "," + a.yx.toFixed(8) + "," + a.xy.toFixed(8) + "," + a.yy.toFixed(8) + "," + a.dx.toFixed(8) + "," + a.dy.toFixed(8) + ")")
            } else
                this.rawNode.removeAttribute("transform");
            return this
        },
        setRawNode: function(a) {
            a = this.rawNode = a;
            "image" != this.shape.type && a.setAttribute("fill", "none");
            a.setAttribute("fill-opacity", 0);
            a.setAttribute("stroke", "none");
            a.setAttribute("stroke-opacity", 0);
            a.setAttribute("stroke-width", 1);
            a.setAttribute("stroke-linecap", "butt");
            a.setAttribute("stroke-linejoin", "miter");
            a.setAttribute("stroke-miterlimit", 4);
            a.__gfxObject__ = this
        },
        setShape: function(a) {
            this.shape = c.makeParameters(this.shape, a);
            for (var b in this.shape)
                "type" != b && this.rawNode.setAttribute(b, this.shape[b]);
            this.bbox = null;
            return this
        },
        _moveToFront: function() {
            this.rawNode.parentNode.appendChild(this.rawNode);
            return this
        },
        _moveToBack: function() {
            this.rawNode.parentNode.insertBefore(this.rawNode, this.rawNode.parentNode.firstChild);
            return this
        },
        setClip: function(a) {
            this.inherited(arguments);
            var c = a ? "width"in a ? "rect" : "cx"in a ? "ellipse" : "points"in a ? "polyline" : "d"in a ? "path" : null : null;
            if (a && !c)
                return this;
            "polyline" === c && (a = b.clone(a),
            a.points = a.points.join(","));
            var e, m = d.get(this.rawNode, "clip-path");
            m && (e = s.byId(m.match(/gfx_clip[\d]+/)[0])) && e.removeChild(e.childNodes[0]);
            a ? (e ? (c = r(f.xmlns.svg, c),
            e.appendChild(c)) : (m = "gfx_clip" + ++z,
            this.rawNode.setAttribute("clip-path", "url(#" + m + ")"),
            e = r(f.xmlns.svg, "clipPath"),
            c = r(f.xmlns.svg, c),
            e.appendChild(c),
            this.rawNode.parentNode.insertBefore(e, this.rawNode),
            d.set(e, "id", m)),
            d.set(c, a)) : (this.rawNode.removeAttribute("clip-path"),
            e && e.parentNode.removeChild(e));
            return this
        },
        _removeClipNode: function() {
            var a, b = d.get(this.rawNode, "clip-path");
            b && (a = s.byId(b.match(/gfx_clip[\d]+/)[0])) && a.parentNode.removeChild(a);
            return a
        }
    });
    f.Group = n("dojox.gfx.svg.Group", f.Shape, {
        constructor: function() {
            e.Container._init.call(this)
        },
        setRawNode: function(a) {
            this.rawNode = a;
            this.rawNode.__gfxObject__ = this
        },
        destroy: function() {
            this.clear(!0);
            f.Shape.prototype.destroy.apply(this, arguments)
        }
    });
    f.Group.nodeType = "g";
    f.Rect = n("dojox.gfx.svg.Rect", [f.Shape, e.Rect], {
        setShape: function(a) {
            this.shape = c.makeParameters(this.shape, a);
            this.bbox = null;
            for (var b in this.shape)
                "type" != b && "r" != b && this.rawNode.setAttribute(b, this.shape[b]);
            null != this.shape.r && (this.rawNode.setAttribute("ry", this.shape.r),
            this.rawNode.setAttribute("rx", this.shape.r));
            return this
        }
    });
    f.Rect.nodeType = "rect";
    f.Ellipse = n("dojox.gfx.svg.Ellipse", [f.Shape, e.Ellipse], {});
    f.Ellipse.nodeType = "ellipse";
    f.Circle = n("dojox.gfx.svg.Circle", [f.Shape, e.Circle], {});
    f.Circle.nodeType = "circle";
    f.Line = n("dojox.gfx.svg.Line", [f.Shape, e.Line], {});
    f.Line.nodeType = "line";
    f.Polyline = n("dojox.gfx.svg.Polyline", [f.Shape, e.Polyline], {
        setShape: function(a, b) {
            a && a instanceof Array ? (this.shape = c.makeParameters(this.shape, {
                points: a
            }),
            b && this.shape.points.length && this.shape.points.push(this.shape.points[0])) : this.shape = c.makeParameters(this.shape, a);
            this.bbox = null;
            this._normalizePoints();
            for (var d = [], f = this.shape.points, e = 0; e < f.length; ++e)
                d.push(f[e].x.toFixed(8), f[e].y.toFixed(8));
            this.rawNode.setAttribute("points", d.join(" "));
            return this
        }
    });
    f.Polyline.nodeType = "polyline";
    f.Image = n("dojox.gfx.svg.Image", [f.Shape, e.Image], {
        setShape: function(a) {
            this.shape = c.makeParameters(this.shape, a);
            this.bbox = null;
            a = this.rawNode;
            for (var b in this.shape)
                "type" != b && "src" != b && a.setAttribute(b, this.shape[b]);
            a.setAttribute("preserveAspectRatio", "none");
            a.setAttributeNS ? a.setAttributeNS(f.xmlns.xlink, "xlink:href", this.shape.src) : a.setAttribute("xlink:href", this.shape.src);
            a.__gfxObject__ = this;
            return this
        }
    });
    f.Image.nodeType = "image";
    f.Text = n("dojox.gfx.svg.Text", [f.Shape, e.Text], {
        setShape: function(a) {
            this.shape = c.makeParameters(this.shape, a);
            this.bbox = null;
            a = this.rawNode;
            var b = this.shape;
            a.setAttribute("x", b.x);
            a.setAttribute("y", b.y);
            a.setAttribute("text-anchor", b.align);
            a.setAttribute("text-decoration", b.decoration);
            a.setAttribute("rotate", b.rotated ? 90 : 0);
            a.setAttribute("kerning", b.kerning ? "auto" : 0);
            a.setAttribute("text-rendering", y);
            a.firstChild ? a.firstChild.nodeValue = b.text : a.appendChild(u(b.text));
            return this
        },
        getTextWidth: function() {
            var a = this.rawNode
              , b = a.parentNode
              , a = a.cloneNode(!0);
            a.style.visibility = "hidden";
            var c = 0
              , d = a.firstChild.nodeValue;
            b.appendChild(a);
            if ("" != d)
                for (; !c; )
                    c = a.getBBox ? parseInt(a.getBBox().width) : 68;
            b.removeChild(a);
            return c
        },
        getBoundingBox: function() {
            var a = null;
            if (this.getShape().text)
                try {
                    a = this.rawNode.getBBox()
                } catch (b) {
                    a = {
                        x: 0,
                        y: 0,
                        width: 0,
                        height: 0
                    }
                }
            return a
        }
    });
    f.Text.nodeType = "text";
    f.Path = n("dojox.gfx.svg.Path", [f.Shape, a.Path], {
        _updateWithSegment: function(a) {
            this.inherited(arguments);
            "string" == typeof this.shape.path && this.rawNode.setAttribute("d", this.shape.path)
        },
        setShape: function(a) {
            this.inherited(arguments);
            this.shape.path ? this.rawNode.setAttribute("d", this.shape.path) : this.rawNode.removeAttribute("d");
            return this
        }
    });
    f.Path.nodeType = "path";
    f.TextPath = n("dojox.gfx.svg.TextPath", [f.Shape, a.TextPath], {
        _updateWithSegment: function(a) {
            this.inherited(arguments);
            this._setTextPath()
        },
        setShape: function(a) {
            this.inherited(arguments);
            this._setTextPath();
            return this
        },
        _setTextPath: function() {
            if ("string" == typeof this.shape.path) {
                var a = this.rawNode;
                if (!a.firstChild) {
                    var b = r(f.xmlns.svg, "textPath")
                      , d = u("");
                    b.appendChild(d);
                    a.appendChild(b)
                }
                b = (b = a.firstChild.getAttributeNS(f.xmlns.xlink, "href")) && f.getRef(b);
                if (!b && (d = this._getParentSurface())) {
                    var d = d.defNode
                      , b = r(f.xmlns.svg, "path")
                      , e = c._base._getUniqueId();
                    b.setAttribute("id", e);
                    d.appendChild(b);
                    a.firstChild.setAttributeNS ? a.firstChild.setAttributeNS(f.xmlns.xlink, "xlink:href", "#" + e) : a.firstChild.setAttribute("xlink:href", "#" + e)
                }
                b && b.setAttribute("d", this.shape.path)
            }
        },
        _setText: function() {
            var a = this.rawNode;
            if (!a.firstChild) {
                var b = r(f.xmlns.svg, "textPath")
                  , c = u("");
                b.appendChild(c);
                a.appendChild(b)
            }
            a = a.firstChild;
            b = this.text;
            a.setAttribute("alignment-baseline", "middle");
            switch (b.align) {
            case "middle":
                a.setAttribute("text-anchor", "middle");
                a.setAttribute("startOffset", "50%");
                break;
            case "end":
                a.setAttribute("text-anchor", "end");
                a.setAttribute("startOffset", "100%");
                break;
            default:
                a.setAttribute("text-anchor", "start"),
                a.setAttribute("startOffset", "0%")
            }
            a.setAttribute("baseline-shift", "0.5ex");
            a.setAttribute("text-decoration", b.decoration);
            a.setAttribute("rotate", b.rotated ? 90 : 0);
            a.setAttribute("kerning", b.kerning ? "auto" : 0);
            a.firstChild.data = b.text
        }
    });
    f.TextPath.nodeType = "text";
    var A = 534 < function() {
        var a = /WebKit\/(\d*)/.exec(w);
        return a ? a[1] : 0
    }();
    f.Surface = n("dojox.gfx.svg.Surface", e.Surface, {
        constructor: function() {
            e.Container._init.call(this)
        },
        destroy: function() {
            e.Container.clear.call(this, !0);
            this.defNode = null;
            this.inherited(arguments)
        },
        setDimensions: function(a, b) {
            if (!this.rawNode)
                return this;
            this.rawNode.setAttribute("width", a);
            this.rawNode.setAttribute("height", b);
            A && (this.rawNode.style.width = a,
            this.rawNode.style.height = b);
            return this
        },
        getDimensions: function() {
            return this.rawNode ? {
                width: c.normalizedLength(this.rawNode.getAttribute("width")),
                height: c.normalizedLength(this.rawNode.getAttribute("height"))
            } : null
        }
    });
    f.createSurface = function(a, b, d) {
        var e = new f.Surface;
        e.rawNode = r(f.xmlns.svg, "svg");
        e.rawNode.setAttribute("overflow", "hidden");
        b && e.rawNode.setAttribute("width", b);
        d && e.rawNode.setAttribute("height", d);
        b = r(f.xmlns.svg, "defs");
        e.rawNode.appendChild(b);
        e.defNode = b;
        e._parent = s.byId(a);
        e._parent.appendChild(e.rawNode);
        c._base._fixMsTouchAction(e);
        return e
    }
    ;
    q = {
        _setFont: function() {
            var a = this.fontStyle;
            this.rawNode.setAttribute("font-style", a.style);
            this.rawNode.setAttribute("font-variant", a.variant);
            this.rawNode.setAttribute("font-weight", a.weight);
            this.rawNode.setAttribute("font-size", a.size);
            this.rawNode.setAttribute("font-family", a.family)
        }
    };
    var t = e.Container;
    n = f.Container = {
        openBatch: function() {
            if (!this._batch) {
                var a;
                a = f.useSvgWeb ? p.doc.createDocumentFragment(!0) : p.doc.createDocumentFragment();
                this.fragment = a
            }
            ++this._batch;
            return this
        },
        closeBatch: function() {
            this._batch = 0 < this._batch ? --this._batch : 0;
            this.fragment && !this._batch && (this.rawNode.appendChild(this.fragment),
            delete this.fragment);
            return this
        },
        add: function(a) {
            this != a.getParent() && (this.fragment ? this.fragment.appendChild(a.rawNode) : this.rawNode.appendChild(a.rawNode),
            t.add.apply(this, arguments),
            a.setClip(a.clip));
            return this
        },
        remove: function(a, b) {
            this == a.getParent() && (this.rawNode == a.rawNode.parentNode && this.rawNode.removeChild(a.rawNode),
            this.fragment && this.fragment == a.rawNode.parentNode && this.fragment.removeChild(a.rawNode),
            a._removeClipNode(),
            t.remove.apply(this, arguments));
            return this
        },
        clear: function() {
            for (var a = this.rawNode; a.lastChild; )
                a.removeChild(a.lastChild);
            var b = this.defNode;
            if (b) {
                for (; b.lastChild; )
                    b.removeChild(b.lastChild);
                a.appendChild(b)
            }
            return t.clear.apply(this, arguments)
        },
        getBoundingBox: t.getBoundingBox,
        _moveChildToFront: t._moveChildToFront,
        _moveChildToBack: t._moveChildToBack
    };
    a = f.Creator = {
        createObject: function(a, b) {
            if (!this.rawNode)
                return null;
            var c = new a
              , d = r(f.xmlns.svg, a.nodeType);
            c.setRawNode(d);
            c.setShape(b);
            this.add(c);
            return c
        }
    };
    b.extend(f.Text, q);
    b.extend(f.TextPath, q);
    b.extend(f.Group, n);
    b.extend(f.Group, e.Creator);
    b.extend(f.Group, a);
    b.extend(f.Surface, n);
    b.extend(f.Surface, e.Creator);
    b.extend(f.Surface, a);
    f.fixTarget = function(a, b) {
        a.gfxTarget || (a.gfxTarget = x && a.target.wholeText ? a.target.parentElement.__gfxObject__ : a.target.__gfxObject__);
        return !0
    }
    ;
    f.useSvgWeb && (f.createSurface = function(a, b, d) {
        var e = new f.Surface;
        if (!b || !d) {
            var h = l.position(a);
            b = b || h.w;
            d = d || h.h
        }
        a = s.byId(a);
        var h = a.id ? a.id + "_svgweb" : c._base._getUniqueId()
          , k = r(f.xmlns.svg, "svg");
        k.id = h;
        k.setAttribute("width", b);
        k.setAttribute("height", d);
        svgweb.appendChild(k, a);
        k.addEventListener("SVGLoad", function() {
            e.rawNode = this;
            e.isLoaded = !0;
            var a = r(f.xmlns.svg, "defs");
            e.rawNode.appendChild(a);
            e.defNode = a;
            if (e.onLoad)
                e.onLoad(e)
        }, !1);
        e.isLoaded = !1;
        return e
    }
    ,
    f.Surface.extend({
        destroy: function() {
            var a = this.rawNode;
            svgweb.removeChild(a, a.parentNode)
        }
    }),
    q = {
        connect: function(a, c, d) {
            "on" === a.substring(0, 2) && (a = a.substring(2));
            d = 2 == arguments.length ? c : b.hitch(c, d);
            this.getEventSource().addEventListener(a, d, !1);
            return [this, a, d]
        },
        disconnect: function(a) {
            this.getEventSource().removeEventListener(a[1], a[2], !1);
            delete a[0]
        }
    },
    b.extend(f.Shape, q),
    b.extend(f.Surface, q));
    return f
});
//# sourceURL=http://openapi.nsdi.go.kr/nsdi/js/eios/map/3.14/dojox/gfx/svg.js
