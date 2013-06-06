package com.example.layouttest;

import android.content.Context;
import android.opengl.GLSurfaceView;
import android.util.AttributeSet;
import android.util.Log;


public class MyGLSurfaceView extends GLSurfaceView {

	public MyGLSurfaceView(Context context) {
		super(context);

		Log.d( "aaa", "MyGLSurfaceView::CTOR" );

		setEGLContextClientVersion(2);
		
		mRenderer = new MyGLES20Renderer();
		setRenderer(mRenderer);

		/** optional
		 *needs call to requestRender()
		 */
		setRenderMode(GLSurfaceView.RENDERMODE_WHEN_DIRTY);
		
	}
	public MyGLSurfaceView(Context context, AttributeSet attrs ) {
		super(context, attrs);

		Log.d( "aaa", "MyGLSurfaceView::CTOR" );

		setEGLContextClientVersion(2);
		
		mRenderer = new MyGLES20Renderer();
		setRenderer(mRenderer);

		/** optional
		 *needs call to requestRender()
		 */
		setRenderMode(GLSurfaceView.RENDERMODE_WHEN_DIRTY);
		
	}
	
	protected MyGLES20Renderer mRenderer;
	
}
