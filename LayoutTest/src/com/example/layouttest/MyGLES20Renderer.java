package com.example.layouttest;
import javax.microedition.khronos.egl.EGLConfig;
import javax.microedition.khronos.opengles.GL10;

import android.opengl.GLES20;
import android.opengl.GLSurfaceView.Renderer;
import android.opengl.Matrix;
import android.util.Log;



public class MyGLES20Renderer implements Renderer {

//	private Triangle mTriangle;
//	private Triangle2 mTriangle2;
//	private Square mSquare;
	private Axes mAxes;
	private DebugPlane mDbugPlane;
//	private VisTree mVisTree;
	
	private float[] mMMatrix	= new float[16];
	private float[] mVMatrix	= new float[16];
	private float[] mProjMatrix = new float[16];
	private float[] mMVPMatrix 	= new float[16];
	
	public static final String vertexShaderCode = 
			"uniform mat4 uMVPMatrix;" +
			"attribute vec4 aPosition;" +
			"attribute vec4 aColor;" +
			"varying   vec4 vColor;" +
		    "void main() {" +
			"	vColor = aColor;" +
		    "  gl_Position = uMVPMatrix * aPosition;" +
		    "}";
	
	public static final String fragmentShaderCode = 
			"precision mediump float;" +
		    "varying vec4 vColor;" +
		    "void main() {" +
		    "  gl_FragColor = vColor;" +
		    "}";

	public static int loadShader( int type, String shaderCode ) {
		int shader = GLES20.glCreateShader(type);
		
		GLES20.glShaderSource(shader, shaderCode);
		GLES20.glCompileShader(shader);
		
		int[] compiled = new int[1];
		GLES20.glGetShaderiv(shader, GLES20.GL_COMPILE_STATUS, compiled,0);
		if( compiled[0] == 0 ) {
			Log.e( "AAA", "Could not compile shader " + type + ":" );
			Log.e("AAA", GLES20.glGetShaderInfoLog(shader));
			
			throw new RuntimeException( "Could not compile shader " 
					+ type + ":" + GLES20.glGetShaderInfoLog(shader) );
		}
		
		return shader;
	}
	
	@Override
	public void onSurfaceCreated(GL10 unused, EGLConfig config) {
		// set background color
		GLES20.glClearColor(0.5f, 0.5f, 0.5f, 1.0f );
		
//		mTriangle	= new Triangle();
//		mSquare		= new Square();
		mAxes 		= new Axes();
		mDbugPlane = new DebugPlane();
//		mVisTree = new VisTree();
	}

	@Override
	public void onDrawFrame(GL10 unused) {
		// redraw background
		GLES20.glClear(GLES20.GL_COLOR_BUFFER_BIT);
		
		Matrix.setIdentityM(mVMatrix, 0);
		Matrix.setIdentityM(mMVPMatrix, 0);
		
		final float cam_x = 15.0f;
		final float cam_y =  5.0f;
		final float cam_z = 15.0f;
		
		final float look_x = 0.0f;
		final float look_y = 0.0f;
		final float look_z = 0.0f;
		
		final float up_x = 0.0f;
		final float up_y = 1.0f;
		final float up_z = 0.0f;
		
		// position "camera"
		Matrix.setLookAtM(mVMatrix, 0, 
				cam_x, cam_y, cam_z,     // eye 
				look_x, look_y, look_z,  // center 
				up_x, up_y, up_z         // up 
				);
		
		Matrix.multiplyMM(
				mMVPMatrix,  0,  // matrix, offset 
				mProjMatrix, 0,  // matrix, offset
				mVMatrix,    0   // matrix, offset
				);
		
//		mTriangle.draw( mMVPMatrix );
//		mVisTree.draw(mMVPMatrix);
		mDbugPlane.draw(mMVPMatrix);
		mAxes.draw(mMVPMatrix);
	}

	@Override
	public void onSurfaceChanged(GL10 unused, int width, int height) {
		
		float ratio = (float) width / height;

		float near = 0.1f;
		float far = 1000.0f;
		
		Matrix.setIdentityM(mProjMatrix, 0);

		GLES20.glViewport(0, 0, width, height);
		
//		Matrix.frustumM( 
//				mProjMatrix, 0, 
//				-ratio, ratio, // left, right
//				-1, 1,         // bottom, top
////				0.1f, 100.0f   // near, far
//				0.99999f, 1200.0f   // near, far
//				);

		//		frustmM method perpectiveM(projection_matrix, 0, 45.0f, ratio, near, far)
		Matrix.perspectiveM(mProjMatrix, 0, 90.0f, ratio, near, far);
	}

	
}
