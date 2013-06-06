package com.example.layouttest;

import android.opengl.GLES20;
import android.util.Log;

public class Axes extends BaseObject {

	public Axes() {
		
		super();
		
		mGLType = GLES20.GL_LINES;
		
		// all-in-one
		mVertexColorBuffer = _initFloatBuffer2(mVertexColorData);
		
		mStrideBytes  = 7 * SIZE_OF_FLOAT;
		mVertexOffset = 0;
		mColorOffset  = COORDS_PER_VERTEX;
		
		mVertexColorCount = mVertexColorData.length / 7;
		
		mColor = mColorData;
		
		// separate buffers
		mColorBuffer = _initFloatBuffer2(mColorData);
		
		mInitShaders();
	}
	
	static private float mCoords[] = {
		-1.0f,  0.0f,  0.0f,
		 1.0f,  0.0f,  0.0f,
		 0.0f, -1.0f,  0.0f,
		 0.0f,  1.0f,  0.0f,
		 0.0f,  0.0f, -1.0f,
		 0.0f,  0.0f,  1.0f
	};

	static private float mVertexColorData[] = {
		// x,y,z
		// r,g,b,a
		
		-10.0f,  0.0f,  0.0f,
		 1.0f,  0.0f,  0.0f, 1.0f,
		 
		 10.0f,  0.0f,  0.0f,
		 1.0f,  0.0f,  0.0f, 1.0f,
		 
		 
		 0.0f, -10.0f,  0.0f,
		 0.0f,  1.0f,  0.0f, 1.0f,
		 
		 0.0f,  10.0f,  0.0f,
		 0.0f,  1.0f,  0.0f, 1.0f,
		 
		 
		 0.0f,  0.0f, -10.0f,
		 0.0f,  0.0f,  1.0f, 1.0f,
		 
		 0.0f,  0.0f,  10.0f,
		 0.0f,  0.0f,  1.0f, 1.0f
	};
	static private float mVertexData[] = {
		// x,y,z
		-1.0f,  0.0f,  0.0f,
		 1.0f,  0.0f,  0.0f,
		 
		 0.0f, -1.0f,  0.0f,
		 0.0f,  1.0f,  0.0f,
		 
		 0.0f,  0.0f, -1.0f,
		 0.0f,  0.0f,  1.0f
	};
	static private float mColorData[] = {
		// r,g,b,a
		 1.0f,  0.0f, 0.0f, 1.0f,
		 1.0f,  0.0f, 0.0f, 1.0f,
		 
		 0.0f,  1.0f, 0.0f, 1.0f,
		 0.0f,  1.0f, 0.0f, 1.0f,
		 
		 0.0f,  0.0f, 1.0f, 1.0f,
		 0.0f,  0.0f, 1.0f, 1.0f
	};
	
//	private float mColorData[] = { 1.0f, 0.0f, 0.0f, 1.0f };
	
}
