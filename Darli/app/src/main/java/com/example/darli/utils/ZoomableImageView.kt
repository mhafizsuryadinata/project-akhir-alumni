package com.example.darli.utils

import android.content.Context
import android.graphics.Matrix
import android.graphics.PointF
import android.util.AttributeSet
import android.view.MotionEvent
import android.view.ScaleGestureDetector
import androidx.appcompat.widget.AppCompatImageView

class ZoomableImageView @JvmOverloads constructor(
    context: Context, attrs: AttributeSet? = null, defStyleAttr: Int = 0
) : AppCompatImageView(context, attrs, defStyleAttr) {

    private var matrix: Matrix = Matrix()
    private var mode = NONE

    private var last = PointF()
    private var start = PointF()
    private var minScale = 1f
    private var maxScale = 5f
    private var m: FloatArray = FloatArray(9)

    private var saveScale = 1f
    private var right = 0f
    private var bottom = 0f
    private var origWidth = 0f
    private var origHeight = 0f

    private var scaleDetector: ScaleGestureDetector

    init {
        super.setClickable(true)
        scaleDetector = ScaleGestureDetector(context, ScaleListener())
        this.imageMatrix = matrix
        this.scaleType = ScaleType.MATRIX
    }

    override fun onMeasure(widthMeasureSpec: Int, heightMeasureSpec: Int) {
        super.onMeasure(widthMeasureSpec, heightMeasureSpec)
        val viewWidth = MeasureSpec.getSize(widthMeasureSpec).toFloat()
        val viewHeight = MeasureSpec.getSize(heightMeasureSpec).toFloat()
        
        if (saveScale == 1f && viewWidth > 0 && viewHeight > 0) {
            val drawable = drawable
            if (drawable == null || drawable.intrinsicWidth == 0 || drawable.intrinsicHeight == 0) return
            
            val bmWidth = drawable.intrinsicWidth
            val bmHeight = drawable.intrinsicHeight
            
            val scaleX = viewWidth / bmWidth
            val scaleY = viewHeight / bmHeight
            
            val scale = scaleX.coerceAtMost(scaleY)
            matrix.setScale(scale, scale)

            var redundantYSpace = viewHeight - scale * bmHeight
            var redundantXSpace = viewWidth - scale * bmWidth
            redundantYSpace /= 2f
            redundantXSpace /= 2f
            
            matrix.postTranslate(redundantXSpace, redundantYSpace)
            
            origWidth = viewWidth - 2 * redundantXSpace
            origHeight = viewHeight - 2 * redundantYSpace
            this.imageMatrix = matrix
        }
        fixTranslation()
    }

    override fun onTouchEvent(event: MotionEvent): Boolean {
        scaleDetector.onTouchEvent(event)
        
        matrix.getValues(m)
        val x = m[Matrix.MTRANS_X]
        val y = m[Matrix.MTRANS_Y]
        val curPoint = PointF(event.x, event.y)
        
        when (event.action) {
            MotionEvent.ACTION_DOWN -> {
                last.set(curPoint)
                start.set(last)
                mode = DRAG
            }
            MotionEvent.ACTION_MOVE -> {
                if (mode == DRAG) {
                    val deltaX = curPoint.x - last.x
                    val deltaY = curPoint.y - last.y
                    val fixTransX = getFixDragTrans(deltaX, width.toFloat(), origWidth * saveScale)
                    val fixTransY = getFixDragTrans(deltaY, height.toFloat(), origHeight * saveScale)
                    matrix.postTranslate(fixTransX, fixTransY)
                    fixTranslation()
                    last.set(curPoint.x, curPoint.y)
                }
            }
            MotionEvent.ACTION_UP, MotionEvent.ACTION_POINTER_UP -> {
                mode = NONE
                val xDiff = Math.abs(curPoint.x - start.x)
                val yDiff = Math.abs(curPoint.y - start.y)
                if (xDiff < CLICK && yDiff < CLICK) performClick()
            }
        }
        
        this.imageMatrix = matrix
        invalidate()
        return true // Important: consume the event
    }

    private fun fixTranslation() {
        matrix.getValues(m)
        val transX = m[Matrix.MTRANS_X]
        val transY = m[Matrix.MTRANS_Y]
        val fixTransX = getFixTrans(transX, width.toFloat(), origWidth * saveScale)
        val fixTransY = getFixTrans(transY, height.toFloat(), origHeight * saveScale)
        if (fixTransX != 0f || fixTransY != 0f) matrix.postTranslate(fixTransX, fixTransY)
    }

    private fun getFixTrans(trans: Float, viewSize: Float, contentSize: Float): Float {
        val minTrans: Float
        val maxTrans: Float
        if (contentSize <= viewSize) {
            minTrans = 0f
            maxTrans = viewSize - contentSize
        } else {
            minTrans = viewSize - contentSize
            maxTrans = 0f
        }
        if (trans < minTrans) return -trans + minTrans
        if (trans > maxTrans) return -trans + maxTrans
        return 0f
    }

    private fun getFixDragTrans(delta: Float, viewSize: Float, contentSize: Float): Float {
        return if (contentSize <= viewSize) {
            0f
        } else delta
    }

    private inner class ScaleListener : ScaleGestureDetector.SimpleOnScaleGestureListener() {
        override fun onScaleBegin(detector: ScaleGestureDetector): Boolean {
            mode = ZOOM
            return true
        }

        override fun onScale(detector: ScaleGestureDetector): Boolean {
            var mScaleFactor = detector.scaleFactor
            val origScale = saveScale
            saveScale *= mScaleFactor
            if (saveScale > maxScale) {
                saveScale = maxScale
                mScaleFactor = maxScale / origScale
            } else if (saveScale < minScale) {
                saveScale = minScale
                mScaleFactor = minScale / origScale
            }
            
            if (origWidth * saveScale <= width || origHeight * saveScale <= height) {
                matrix.postScale(mScaleFactor, mScaleFactor, width / 2f, height / 2f)
            } else {
                matrix.postScale(mScaleFactor, mScaleFactor, detector.focusX, detector.focusY)
            }
            
            fixTranslation()
            return true
        }
    }

    companion object {
        private const val NONE = 0
        private const val DRAG = 1
        private const val ZOOM = 2
        private const val CLICK = 3
    }
}
